<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->with(['category', 'images'])
            ->where('is_active', true)
            ->latest()
            ->paginate(9);

        return view('storefront.catalog', compact('products'));
    }

    public function show(string $slug)
    {
        $product = Product::query()
            ->with(['category', 'images', 'sizes' => function ($query) {
                $query->where('is_active', true)->orderBy('size');
            }])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::query()
            ->with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        return view('storefront.product-show', compact('product', 'relatedProducts'));
    }
}
