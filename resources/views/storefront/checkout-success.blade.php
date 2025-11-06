@extends('storefront.layouts.app')

@section('title', 'Pesanan Berhasil - Nstore')

@section('content')
    <section class="bg-brand-white py-16">
        <div class="mx-auto w-full max-w-4xl px-6">
            <div class="rounded-3xl border border-brand-black/10 bg-brand-white p-8 text-center shadow-sm shadow-black/5">
                <span class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-brand-black text-2xl text-brand-white">✓</span>
                <h1 class="mt-6 text-3xl font-semibold">Terima kasih! Pesanan kamu diterima.</h1>
                <p class="mt-2 text-sm text-brand-darkGray">Kami sudah mengirimkan konfirmasi ke <span class="font-semibold text-brand-black">{{ $order->customer_email }}</span>. Tim kami akan segera memprosesnya.</p>

                <div class="mt-8 grid gap-6 rounded-3xl border border-brand-black/10 bg-brand-gray/60 p-6 text-left text-sm text-brand-darkGray">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-xs uppercase tracking-[0.3em]">Nomor Pesanan</div>
                            <div class="mt-1 text-lg font-semibold text-brand-black">{{ $order->order_number }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs uppercase tracking-[0.3em]">Tanggal</div>
                            <div class="mt-1 font-semibold text-brand-black">{{ $order->created_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>

                    <div>
                        <div class="text-xs uppercase tracking-[0.3em]">Detail Pengiriman</div>
                        <div class="mt-2 space-y-1">
                            <div class="font-semibold text-brand-black">{{ $order->customer_name }}</div>
                            <div>{{ $order->customer_phone }}</div>
                            <div>{{ $order->shipping_address }}</div>
                        </div>
                    </div>

                    <div>
                        <div class="text-xs uppercase tracking-[0.3em]">Metode Pembayaran</div>
                        <div class="mt-2 font-semibold text-brand-black">{{ strtoupper($order->payment_method) }}</div>
                        @if ($order->payment_method === 'transfer')
                            <div class="mt-3 rounded-2xl bg-brand-white/70 p-4 text-xs text-brand-darkGray">
                                <div>Status Pembayaran: <span class="font-semibold text-brand-black">{{ ucwords(str_replace('_', ' ', $order->payment_status)) }}</span></div>
                                @if ($order->payment_proof_path)
                                    <a href="{{ Storage::disk('public')->url($order->payment_proof_path) }}" target="_blank" class="mt-2 inline-flex items-center gap-2 rounded-full border border-brand-black px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.3em] text-brand-black transition hover:bg-brand-black hover:text-brand-white">Lihat Bukti Pembayaran</a>
                                @else
                                    <p class="mt-2">Belum ada bukti pembayaran yang diunggah. Kirim bukti melalui WhatsApp admin untuk mempercepat proses.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-10 space-y-4 text-left">
                    <h2 class="text-lg font-semibold">Item Pesanan</h2>
                    <div class="space-y-3 rounded-3xl border border-brand-black/10 bg-brand-white p-6 text-sm text-brand-darkGray">
                        @foreach ($order->items as $item)
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="font-semibold text-brand-black">{{ $item->product_name }}</div>
                                    <div>Qty {{ $item->quantity }} @ {{ $item->product_size ?? 'Free Size' }}</div>
                                </div>
                                <div class="text-sm font-semibold text-brand-black">Rp {{ number_format($item->total, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 grid gap-2 text-sm text-brand-darkGray">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-semibold text-brand-black">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Ongkir</span>
                        <span class="font-semibold text-brand-black">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-semibold text-brand-black">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('home') }}" class="rounded-full border border-brand-black px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-brand-black transition hover:bg-brand-black hover:text-brand-white">Kembali ke Home</a>
                    <a href="{{ route('storefront.catalog') }}" class="rounded-full bg-brand-black px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-brand-white transition hover:bg-brand-darkGray">Lanjut Belanja</a>
                </div>
            </div>
        </div>
    </section>
@endsection
