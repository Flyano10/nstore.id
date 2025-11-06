<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSize;
use App\Mail\OrderCreatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $cart = collect($request->session()->get('cart', []));

        if ($cart->isEmpty()) {
            return redirect()->route('storefront.cart.index')->withErrors(['cart' => 'Keranjang kamu masih kosong.']);
        }

        $items = $cart->map(function ($item) {
            $subtotal = $item['price'] * $item['quantity'];

            return $item + ['subtotal' => $subtotal];
        });

        $subtotal = $items->sum('subtotal');
        $shippingCost = $items->isEmpty() ? 0 : $this->shippingCost();
        $total = $subtotal + $shippingCost;

        return view('storefront.checkout', [
            'items' => $items,
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $cart = collect($request->session()->get('cart', []));

        if ($cart->isEmpty()) {
            return redirect()->route('storefront.cart.index')->withErrors(['cart' => 'Keranjang kamu masih kosong.']);
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cod,transfer'],
            'notes' => ['nullable', 'string'],
            'payment_proof' => [
                Rule::requiredIf(fn () => $request->input('payment_method') === 'transfer'),
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:4096',
            ],
        ]);

        $items = $cart->map(function ($item) {
            $item['subtotal'] = $item['price'] * $item['quantity'];

            return $item;
        });

        $paymentProofPath = null;

        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        foreach ($items as $item) {
            $productExists = Product::query()
                ->where('id', $item['product_id'])
                ->where('is_active', true)
                ->exists();

            if (! $productExists) {
                return redirect()->route('storefront.cart.index')->withErrors([
                    'cart' => "Produk {$item['product_name']} tidak tersedia lagi.",
                ]);
            }

            if ($item['size_id']) {
                $size = ProductSize::find($item['size_id']);

                if (! $size || $size->stock < $item['quantity']) {
                    return redirect()->route('storefront.cart.index')->withErrors([
                        'cart' => "Stok ukuran {$item['size_label']} untuk {$item['product_name']} tidak mencukupi.",
                    ]);
                }
            }
        }

        $subtotal = $items->sum('subtotal');
        $shippingCost = $items->isEmpty() ? 0 : $this->shippingCost();
        $total = $subtotal + $shippingCost;

        $order = DB::transaction(function () use ($data, $items, $subtotal, $shippingCost, $total, $paymentProofPath) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $this->generateOrderNumber(),
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
                'shipping_address' => $data['shipping_address'],
                'status' => 'pending',
                'payment_method' => $data['payment_method'],
                'payment_status' => $data['payment_method'] === 'cod' ? 'unpaid' : ($paymentProofPath ? 'awaiting_confirmation' : 'awaiting_payment'),
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'notes' => Arr::get($data, 'notes'),
                'payment_proof_path' => $paymentProofPath,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_size_id' => $item['size_id'],
                    'product_name' => $item['product_name'],
                    'product_sku' => $item['sku'],
                    'product_size' => $item['size_label'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['subtotal'],
                ]);

                if ($item['size_id']) {
                    ProductSize::where('id', $item['size_id'])->decrement('stock', $item['quantity']);
                }
            }

            return $order;
        });

        try {
            Mail::to($order->customer_email)->queue(new OrderCreatedMail($order));
        } catch (\Throwable $exception) {
            Log::warning('Gagal mengirim email pesanan baru', [
                'order_id' => $order->id,
                'message' => $exception->getMessage(),
            ]);
        }

        $request->session()->forget('cart');

        return redirect()->route('storefront.checkout.success', ['order' => $order->order_number])->with('status', 'Pesanan berhasil dibuat.');
    }

    protected function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-' . strtoupper(Str::random(6));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }

    public function success(Order $order)
    {
        $order->load(['items']);

        return view('storefront.checkout-success', compact('order'));
    }

    protected function shippingCost(): float
    {
        return 30000;
    }
}
