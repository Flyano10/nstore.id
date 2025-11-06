@extends('storefront.layouts.app')

@section('title', 'Pesanan Saya - Nstore')

@section('content')
    <section class="bg-brand-white py-16">
        <div class="mx-auto w-full max-w-6xl px-6">
            <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold">Pesanan Saya</h1>
                    <p class="mt-2 text-sm text-brand-darkGray">Lihat status terbaru dan detail pesananmu.</p>
                </div>

                @if ($orders->count())
                    <form method="GET" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray">
                        <span>Total Pesanan: {{ $orders->total() }}</span>
                    </form>
                @endif
            </div>

            @forelse ($orders as $order)
                <div class="mt-10 space-y-4 rounded-3xl border border-brand-black/10 bg-brand-gray/60 p-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <div class="text-xs uppercase tracking-[0.3em] text-brand-darkGray">Nomor Pesanan</div>
                            <div class="mt-1 text-lg font-semibold text-brand-black">{{ $order->order_number }}</div>
                        </div>
                        <div class="text-right text-sm text-brand-darkGray">
                            <div>{{ $order->created_at->format('d M Y H:i') }}</div>
                            <div>{{ $order->items_count }} item</div>
                        </div>
                    </div>

                    <div class="grid gap-4 text-sm text-brand-darkGray md:grid-cols-4">
                        <div>
                            <span class="text-xs uppercase tracking-[0.3em]">Status Pesanan</span>
                            <div class="mt-1 font-semibold text-brand-black">{{ ucfirst($order->status) }}</div>
                        </div>
                        <div>
                            <span class="text-xs uppercase tracking-[0.3em]">Pembayaran</span>
                            <div class="mt-1 font-semibold text-brand-black">{{ strtoupper($order->payment_method) }}</div>
                            <div class="text-xs text-brand-darkGray">{{ ucwords(str_replace('_', ' ', $order->payment_status)) }}</div>
                        </div>
                        <div>
                            <span class="text-xs uppercase tracking-[0.3em]">Total</span>
                            <div class="mt-1 font-semibold text-brand-black">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                        </div>
                        <div class="flex items-end justify-start md:justify-end">
                            <a href="{{ route('storefront.orders.show', $order->order_number) }}" class="inline-flex items-center gap-2 rounded-full border border-brand-black px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-black transition hover:bg-brand-black hover:text-brand-white">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="mt-12 rounded-3xl border border-dashed border-brand-black/10 bg-brand-gray p-12 text-center">
                    <h2 class="text-xl font-semibold text-brand-black">Belum ada pesanan.</h2>
                    <p class="mt-2 text-sm text-brand-darkGray">Mulai belanja sneaker favoritmu di katalog.</p>
                    <a href="{{ route('storefront.catalog') }}" class="mt-6 inline-flex rounded-full bg-brand-black px-6 py-3 text-sm font-semibold text-brand-white transition hover:bg-brand-darkGray">Lihat Katalog</a>
                </div>
            @endforelse

            @if ($orders->hasPages())
                <div class="mt-10">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
