@extends('storefront.layouts.app')

@section('title', 'Keranjang Belanja - Nstore')

@section('content')
    <section class="bg-brand-white py-16">
        <div class="mx-auto w-full max-w-6xl px-6">
            <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold">Keranjang</h1>
                    <p class="mt-1 text-sm text-brand-darkGray">Cek kembali item sebelum lanjut ke checkout.</p>
                </div>
                @if ($cartItems->isNotEmpty())
                    <form action="{{ route('storefront.cart.destroyAll') }}" method="POST" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray transition hover:text-brand-black">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Kosongkan keranjang?')">Kosongkan Keranjang</button>
                    </form>
                @endif
            </div>

            @if ($cartItems->isEmpty())
                <div class="mt-12 rounded-3xl border border-dashed border-brand-black/10 bg-brand-gray p-12 text-center">
                    <h2 class="text-xl font-semibold text-brand-black">Keranjang kamu masih kosong.</h2>
                    <p class="mt-2 text-sm text-brand-darkGray">Mulai belanja sneaker favorit di katalog.</p>
                    <a href="{{ route('storefront.catalog') }}" class="mt-6 inline-flex rounded-full bg-brand-black px-6 py-3 text-sm font-semibold text-brand-white transition hover:bg-brand-darkGray">Lihat Katalog</a>
                </div>
            @else
                <div class="mt-10 grid gap-10 lg:grid-cols-[2fr,1fr]">
                    <div class="space-y-6">
                        @foreach ($cartItems as $item)
                            <div class="flex flex-col gap-4 rounded-3xl border border-brand-black/10 bg-brand-gray/60 p-6 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex gap-4">
                                    <div class="h-28 w-28 overflow-hidden rounded-2xl border border-brand-black/10 bg-brand-gray">
                                        <img src="{{ $item['image_url'] }}" alt="{{ $item['product_name'] }}" class="h-full w-full object-cover">
                                    </div>
                                    <div class="space-y-1 text-sm">
                                        <h3 class="text-lg font-semibold text-brand-black">{{ $item['product_name'] }}</h3>
                                        <div class="text-brand-darkGray">SKU: {{ $item['sku'] }}</div>
                                        @if ($item['size_label'])
                                            <div class="text-brand-darkGray">Ukuran: {{ $item['size_label'] }}</div>
                                        @endif
                                        <div class="font-semibold">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                                    </div>
                                </div>

                                <div class="flex flex-1 flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-end">
                                    <form action="{{ route('storefront.cart.update', $item['key']) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <label for="qty-{{ $item['key'] }}" class="text-xs uppercase tracking-[0.3em] text-brand-darkGray">Qty</label>
                                        <input id="qty-{{ $item['key'] }}" type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-20 rounded-full border border-brand-black/20 bg-brand-white px-3 py-2 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20">
                                        <button type="submit" class="rounded-full border border-brand-black px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-black transition hover:bg-brand-black hover:text-brand-white">Update</button>
                                    </form>

                                    <div class="text-right text-sm font-semibold text-brand-black">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </div>

                                    <form action="{{ route('storefront.cart.destroy', $item['key']) }}" method="POST" class="text-xs font-semibold uppercase tracking-[0.3em] text-red-500">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus item ini?')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <aside class="space-y-5 rounded-3xl border border-brand-black/10 bg-brand-white p-6 shadow-sm shadow-black/5">
                        <h2 class="text-lg font-semibold">Ringkasan</h2>
                        <div class="space-y-3 text-sm text-brand-darkGray">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span class="font-semibold text-brand-black">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Ongkir</span>
                                <span class="font-semibold text-brand-black">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-lg font-semibold text-brand-black">
                                <span>Total</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('storefront.checkout.create') }}" class="block rounded-full bg-brand-black px-6 py-3 text-center text-sm font-semibold text-brand-white transition hover:bg-brand-darkGray">Lanjut Checkout</a>
                    </aside>
                </div>
            @endif
        </div>
    </section>
@endsection
