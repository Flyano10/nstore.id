<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $heroProduct = Product::query()
            ->with(['category', 'images'])
            ->where('is_active', true)
            ->latest()
            ->first();

        $highlightProducts = Product::query()
            ->with(['category', 'images'])
            ->where('is_active', true)
            ->when($heroProduct, fn ($query) => $query->where('id', '!=', $heroProduct->id))
            ->latest()
            ->take(3)
            ->get();

        $featuredProducts = Product::query()
            ->with(['category', 'images'])
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        $bestSellers = Product::query()
            ->with(['images'])
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('storefront.home', compact('heroProduct', 'highlightProducts', 'featuredProducts', 'bestSellers'));
    }
}
