@extends('storefront.layouts.app')

@section('title', 'Detail Pesanan - Nstore')

@section('content')
    <section class="bg-brand-white py-16">
        <div class="mx-auto w-full max-w-5xl px-6">
            <a href="{{ route('storefront.orders.index') }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray transition hover:text-brand-black">← Kembali ke daftar pesanan</a>

            <div class="mt-6 rounded-3xl border border-brand-black/10 bg-brand-white p-8 shadow-sm shadow-black/5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-semibold">Pesanan #{{ $order->order_number }}</h1>
                        <p class="mt-1 text-sm text-brand-darkGray">Dibuat pada {{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="text-right text-sm text-brand-darkGray">
                        <div>Status Pesanan</div>
                        <div class="text-lg font-semibold text-brand-black">{{ ucfirst($order->status) }}</div>
                    </div>
                </div>

                <div class="mt-6 grid gap-6 rounded-3xl border border-brand-black/10 bg-brand-gray/60 p-6 md:grid-cols-2">
                    <div class="space-y-3 text-sm text-brand-darkGray">
                        <h2 class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-black">Detail Pengiriman</h2>
                        <div class="font-semibold text-brand-black">{{ $order->customer_name }}</div>
                        <div>{{ $order->customer_phone }}</div>
                        <div>{{ $order->customer_email }}</div>
                        <div>{{ $order->shipping_address }}</div>
                    </div>

                    <div class="space-y-3 text-sm text-brand-darkGray">
                        <h2 class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-black">Pembayaran</h2>
                        <div class="font-semibold text-brand-black">Metode: {{ strtoupper($order->payment_method) }}</div>
                        <div>Status: {{ ucwords(str_replace('_', ' ', $order->payment_status)) }}</div>

                        @if ($order->payment_method === 'transfer')
                            <div class="rounded-2xl border border-brand-black/10 bg-brand-white p-4 text-xs">
                                <div>Transfer ke BCA 123456789 a.n. Nstore.</div>
                                @if ($order->payment_proof_path)
                                    <a href="{{ Storage::disk('public')->url($order->payment_proof_path) }}" target="_blank" class="mt-2 inline-flex items-center gap-2 rounded-full border border-brand-black px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.3em] text-brand-black transition hover:bg-brand-black hover:text-brand-white">Lihat Bukti Pembayaran</a>
                                @else
                                    <p class="mt-2 text-brand-darkGray/80">Belum ada bukti bayar. Upload bisa dilakukan melalui kontak admin.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-8">
                    <h2 class="text-lg font-semibold">Item Pesanan</h2>
                    <div class="mt-4 space-y-3">
                        @foreach ($order->items as $item)
                            <div class="flex flex-wrap items-start justify-between gap-3 rounded-3xl border border-brand-black/10 bg-brand-gray/40 p-4 text-sm text-brand-darkGray">
                                <div>
                                    <div class="font-semibold text-brand-black">{{ $item->product_name }}</div>
                                    <div>SKU: {{ $item->product_sku }}</div>
                                    @if ($item->product_size)
                                        <div>Ukuran: {{ $item->product_size }}</div>
                                    @endif
                                    <div>Qty: {{ $item->quantity }}</div>
                                </div>
                                <div class="text-right text-sm font-semibold text-brand-black">Rp {{ number_format($item->total, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 grid gap-3 rounded-3xl border border-brand-black/10 bg-brand-white p-6 text-sm text-brand-darkGray md:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <div class="text-xs uppercase tracking-[0.3em]">Subtotal</div>
                        <div class="mt-1 text-lg font-semibold text-brand-black">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-[0.3em]">Ongkir</div>
                        <div class="mt-1 text-lg font-semibold text-brand-black">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-[0.3em]">Total</div>
                        <div class="mt-1 text-lg font-semibold text-brand-black">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                    </div>
                </div>

                @if ($order->notes)
                    <div class="mt-6 rounded-3xl border border-brand-black/10 bg-brand-gray/60 p-4 text-sm text-brand-darkGray">
                        <div class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-black">Catatan</div>
                        <p class="mt-2 leading-relaxed">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
