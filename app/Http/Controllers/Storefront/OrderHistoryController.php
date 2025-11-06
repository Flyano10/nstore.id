<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return view('storefront.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        if (! $request->user() || $order->user_id !== $request->user()->id) {
            abort(404);
        }

        $order->load(['items']);

        return view('storefront.orders.show', compact('order'));
    }
}
