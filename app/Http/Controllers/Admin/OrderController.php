<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'items.size', 'user']);

        $statusOptions = ['pending', 'processing', 'completed', 'cancelled'];
        $paymentStatusOptions = ['unpaid', 'paid', 'refunded'];

        return view('admin.orders.show', compact('order', 'statusOptions', 'paymentStatusOptions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return redirect()->route('admin.orders.show', $order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $statusOptions = ['pending', 'processing', 'completed', 'cancelled'];
        $paymentStatusOptions = ['unpaid', 'paid', 'refunded'];

        $data = $request->validate([
            'status' => ['required', Rule::in($statusOptions)],
            'payment_status' => ['required', Rule::in($paymentStatusOptions)],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($order, $data) {
            $order->update($data);
        });

        return back()->with('status', 'Status pesanan diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->items()->delete();
            $order->delete();
        });

        return redirect()
            ->route('admin.orders.index')
            ->with('status', 'Pesanan berhasil dihapus.');
    }

    public function paymentProof(Order $order)
    {
        if (! $order->payment_proof_path) {
            abort(404);
        }

        if (! Storage::disk('public')->exists($order->payment_proof_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($order->payment_proof_path);
    }
}
