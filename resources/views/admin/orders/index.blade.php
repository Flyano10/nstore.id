@php
    use Illuminate\Support\Str;
@endphp

@extends('admin.layouts.app')

@section('title', 'Pesanan')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold">Manajemen Pesanan</h2>
            <p class="mt-1 text-sm text-brand-darkGray">Pantau dan kelola status pesanan pelanggan kamu.</p>
        </div>
    </div>

    <div class="rounded-2xl bg-brand-white shadow-sm shadow-black/5">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[960px] text-left text-sm">
                <thead>
                    <tr class="border-b border-brand-gray text-xs uppercase tracking-wide text-brand-darkGray">
                        <th class="px-6 py-4 font-semibold">Order</th>
                        <th class="px-6 py-4 font-semibold">Customer</th>
                        <th class="px-6 py-4 font-semibold">Total</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Pembayaran</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-gray/70">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-brand-gray/60">
                            <td class="px-6 py-4 font-semibold">
                                <div>{{ $order->order_number }}</div>
                                <div class="text-xs text-brand-darkGray">{{ $order->items_count }} item</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-darkGray">
                                <div class="font-medium text-brand-black">{{ $order->customer_name }}</div>
                                <div>{{ $order->customer_email }}</div>
                                <div>{{ $order->customer_phone }}</div>
                            </td>
                            <td class="px-6 py-4 font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold bg-brand-black text-brand-white">
                                    {{ Str::upper($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $order->payment_status === 'paid' ? 'bg-green-500 text-white' : 'bg-brand-gray text-brand-darkGray' }}">
                                    {{ Str::upper($order->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-darkGray">{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="rounded-full border border-brand-black/10 px-4 py-1.5 text-xs font-semibold text-brand-black transition hover:bg-brand-gray">Detail</a>
                                    <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Hapus pesanan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-full border border-red-300 px-4 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-brand-darkGray">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-brand-gray/70 px-6 py-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
