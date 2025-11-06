@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl bg-brand-white p-6 shadow-sm shadow-black/5">
            <p class="text-sm font-medium text-brand-darkGray">Total Produk</p>
            <p class="mt-3 text-3xl font-semibold">{{ number_format($stats['total_products']) }}</p>
        </article>
        <article class="rounded-2xl bg-brand-white p-6 shadow-sm shadow-black/5">
            <p class="text-sm font-medium text-brand-darkGray">Kategori</p>
            <p class="mt-3 text-3xl font-semibold">{{ number_format($stats['total_categories']) }}</p>
        </article>
        <article class="rounded-2xl bg-brand-white p-6 shadow-sm shadow-black/5">
            <p class="text-sm font-medium text-brand-darkGray">Total Pesanan</p>
            <p class="mt-3 text-3xl font-semibold">{{ number_format($stats['total_orders']) }}</p>
        </article>
        <article class="rounded-2xl bg-brand-white p-6 shadow-sm shadow-black/5">
            <p class="text-sm font-medium text-brand-darkGray">Pesanan Pending</p>
            <p class="mt-3 text-3xl font-semibold">{{ number_format($stats['pending_orders']) }}</p>
        </article>
    </section>

    <section class="mt-10 grid gap-6 lg:grid-cols-5">
        <article class="rounded-2xl bg-brand-white p-6 shadow-sm shadow-black/5 lg:col-span-3">
            <header class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold">Pesanan Terbaru</h2>
                <a href="#" class="text-sm font-medium text-brand-darkGray hover:text-brand-black">Lihat semua</a>
            </header>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[500px] text-left text-sm">
                    <thead>
                        <tr class="border-b border-brand-gray text-brand-darkGray">
                            <th class="pb-3 font-medium">Order</th>
                            <th class="pb-3 font-medium">Customer</th>
                            <th class="pb-3 font-medium">Total</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-gray">
                        @forelse ($latestOrders as $order)
                            <tr>
                                <td class="py-3 font-medium">{{ $order->order_number }}</td>
                                <td class="py-3">
                                    <div class="font-medium">{{ $order->customer_name }}</div>
                                    <div class="text-xs text-brand-darkGray">{{ $order->customer_email }}</div>
                                </td>
                                <td class="py-3 font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="py-3">
                                    <span class="inline-flex rounded-full bg-brand-black px-3 py-1 text-xs font-semibold uppercase text-brand-white">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="py-3 text-sm text-brand-darkGray">{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-sm text-brand-darkGray">
                                    Belum ada pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="rounded-2xl bg-brand-white p-6 shadow-sm shadow-black/5 lg:col-span-2">
            <header class="mb-4">
                <h2 class="text-lg font-semibold">Ringkasan Pengguna</h2>
            </header>
            <p class="text-sm text-brand-darkGray">
                Total pengguna terdaftar: <span class="font-semibold text-brand-black">{{ number_format($stats['total_users']) }}</span>
            </p>
            <p class="mt-3 text-sm text-brand-darkGray">
                Gunakan menu di sidebar untuk mengelola kategori, produk, dan pesanan kamu.
            </p>
        </article>
    </section>
@endsection
