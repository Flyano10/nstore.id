<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = collect($this->getCart($request));

        $cartItems = $cart->map(function (array $item, $key) {
            $item['key'] = $item['key'] ?? $key;

            return $item + [
                'subtotal' => $item['price'] * $item['quantity'],
            ];
        })->values();

        $subtotal = $cartItems->sum('subtotal');
        $shippingCost = $cartItems->isEmpty() ? 0 : $this->shippingCost();
        $total = $subtotal + $shippingCost;

        return view('storefront.cart', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'size_id' => ['nullable', 'exists:product_sizes,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::query()
            ->with(['images', 'sizes' => function ($query) {
                $query->where('is_active', true);
            }])
            ->where('is_active', true)
            ->findOrFail($data['product_id']);

        $activeSizes = $product->sizes;

        if ($activeSizes->isNotEmpty() && empty($data['size_id'])) {
            return back()->withErrors(['size_id' => 'Pilih ukuran terlebih dahulu.']);
        }

        $size = null;
        if (! empty($data['size_id'])) {
            $size = ProductSize::query()
                ->where('product_id', $product->id)
                ->where('is_active', true)
                ->findOrFail($data['size_id']);
        }

        if ($size && $size->stock <= 0) {
            return back()->withErrors(['size_id' => 'Ukuran yang dipilih sedang habis stok.']);
        }

        $price = $size && $size->price ? (float) $size->price : (float) $product->price;
        $maxQuantity = $size ? max(0, (int) $size->stock) : 99;

        if ($maxQuantity === 0) {
            return back()->withErrors(['quantity' => 'Stok produk ini tidak tersedia.']);
        }

        $cart = $this->getCart($request);
        $key = $this->buildLineKey($product->id, $size?->id);

        $quantity = min((int) $data['quantity'], $maxQuantity);

        if (isset($cart[$key])) {
            $existingQty = $cart[$key]['quantity'];
            $quantity = min($existingQty + $quantity, $maxQuantity);
            $cart[$key]['quantity'] = $quantity;
            $cart[$key]['price'] = $price;
            $cart[$key]['max_quantity'] = $maxQuantity;
            $cart[$key]['key'] = $key;
        } else {
            $cart[$key] = [
                'key' => $key,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_slug' => $product->slug,
                'sku' => $product->sku,
                'size_id' => $size?->id,
                'size_label' => $size?->size,
                'price' => $price,
                'quantity' => $quantity,
                'max_quantity' => $maxQuantity,
                'image_url' => $product->featured_image_url,
            ];
        }

        $this->saveCart($request, $cart);

        return back()->with('status', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, string $key)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getCart($request);

        if (! isset($cart[$key])) {
            return redirect()->route('storefront.cart.index')->withErrors(['cart' => 'Item tidak ditemukan di keranjang.']);
        }

        $max = Arr::get($cart[$key], 'max_quantity', 99);
        $quantity = min((int) $data['quantity'], $max > 0 ? $max : (int) $data['quantity']);
        $quantity = max(1, $quantity);

        $cart[$key]['quantity'] = $quantity;

        $this->saveCart($request, $cart);

        return redirect()->route('storefront.cart.index')->with('status', 'Keranjang diperbarui.');
    }

    public function destroy(Request $request, string $key)
    {
        $cart = $this->getCart($request);
        unset($cart[$key]);
        $this->saveCart($request, $cart);

        return redirect()->route('storefront.cart.index')->with('status', 'Item dihapus dari keranjang.');
    }

    public function destroyAll(Request $request)
    {
        $request->session()->forget('cart');

        return redirect()->route('storefront.cart.index')->with('status', 'Keranjang dikosongkan.');
    }

    protected function getCart(Request $request): array
    {
        return $request->session()->get('cart', []);
    }

    protected function saveCart(Request $request, array $cart): void
    {
        $request->session()->put('cart', $cart);
    }

    protected function buildLineKey(int $productId, ?int $sizeId): string
    {
        return (string) $productId . '-' . ($sizeId ?? 'default');
    }

    protected function shippingCost(): float
    {
        return 30000;
    }
}
