<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'sizes'])
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if (! $request->hasFile('image_files')) {
            return back()
                ->withErrors(['image_files' => 'Upload minimal satu gambar produk.'])
                ->withInput();
        }

        DB::transaction(function () use ($data, $request) {
            $product = Product::create($data);

            $this->syncImages($product, $request);
            $this->syncSizes($product, $request->input('sizes_data'));
        });

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load(['images' => fn ($query) => $query->orderBy('sort_order'), 'sizes']);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, $product->id);

        DB::transaction(function () use ($data, $request, $product) {
            $product->update($data);

            $this->syncImages($product, $request);
            $this->syncSizes($product, $request->input('sizes_data'));
        });

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            $product->images()->delete();
            $product->sizes()->delete();
            $product->delete();
        });

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Produk berhasil dihapus.');
    }

    protected function validateData(Request $request, ?int $productId = null): array
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . ($productId ?? 'NULL')],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,' . ($productId ?? 'NULL')],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image_files' => ['nullable', 'array'],
            'image_files.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $validated['brand'] = $validated['brand'] ?? 'Nike';
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }

    protected function syncImages(Product $product, Request $request): void
    {
        $existingImages = $product->images()->orderBy('sort_order')->get();
        $removeIds = collect($request->input('remove_images', []))
            ->map(fn ($value) => (int) $value)
            ->filter()
            ->all();

        $keptImages = $existingImages->reject(fn ($image) => in_array($image->id, $removeIds, true))->values();
        $removedImages = $existingImages->filter(fn ($image) => in_array($image->id, $removeIds, true));

        foreach ($removedImages as $image) {
            if ($image->path && ! Str::startsWith($image->path, ['http://', 'https://'])) {
                Storage::disk('public')->delete($image->path);
            }
        }

        $uploadedPaths = collect($request->file('image_files', []))
            ->filter()
            ->map(fn ($file) => $file->store('products', 'public'));

        $paths = $keptImages
            ->pluck('path')
            ->concat($uploadedPaths)
            ->values();

        $product->images()->delete();

        foreach ($paths as $index => $path) {
            $product->images()->create([
                'path' => $path,
                'sort_order' => $index,
                'is_primary' => $index === 0,
            ]);
        }
    }

    protected function syncSizes(Product $product, ?string $sizesInput): void
    {
        $lines = collect(preg_split('/\r\n|\r|\n/', (string) $sizesInput))
            ->map(fn ($value) => trim($value))
            ->filter();

        $product->sizes()->delete();

        foreach ($lines as $line) {
            $parts = array_map('trim', explode('|', $line));
            [$size, $stock, $price] = array_pad($parts, 3, null);

            if (! $size) {
                continue;
            }

            $product->sizes()->create([
                'size' => $size,
                'stock' => (int) ($stock ?? 0),
                'price' => $price !== null && $price !== '' ? (float) $price : null,
                'is_active' => true,
            ]);
        }
    }
}
