@php
    use Illuminate\Support\Str;
@endphp

@extends('storefront.layouts.app')

@section('title', 'Katalog Produk - Nstore')

@section('content')
    <section class="bg-brand-white py-16">
        <div class="mx-auto w-full max-w-6xl px-6">
            <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
                <div>
                    <h1 class="text-3xl font-semibold">Katalog Produk</h1>
                    <p class="mt-2 text-sm text-brand-darkGray">Eksplor semua koleksi sneakers Nike di Nstore.</p>
                </div>
                <a href="{{ route('home') }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray transition hover:text-brand-black">Kembali ke Home</a>
            </div>

            <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($products as $product)
                    <article class="group flex flex-col overflow-hidden rounded-3xl border border-brand-black/5 bg-brand-white shadow-sm shadow-black/5">
                        <div class="relative aspect-[4/3] overflow-hidden bg-brand-gray/60">
                            <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <span class="absolute left-4 top-4 rounded-full bg-brand-black px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-white">{{ $product->category->name ?? 'Nike' }}</span>
                        </div>
                        <div class="flex flex-1 flex-col px-6 py-5">
                            <div class="text-xs uppercase tracking-[0.3em] text-brand-darkGray">{{ $product->brand }}</div>
                            <h3 class="mt-2 text-lg font-semibold text-brand-black">{{ $product->name }}</h3>
                            <p class="mt-3 flex-1 text-sm text-brand-darkGray">{{ Str::limit($product->short_description, 90) }}</p>
                            <div class="mt-6 flex items-center justify-between">
                                <div class="text-lg font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <a href="{{ route('storefront.product.show', $product->slug) }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-black transition hover:text-brand-darkGray">Detail</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-3xl border border-dashed border-brand-black/10 bg-brand-gray p-12 text-center">
                        <h3 class="text-lg font-semibold text-brand-black">Belum ada produk</h3>
                        <p class="mt-2 text-sm text-brand-darkGray">Tambah produk dari dashboard admin untuk mulai menampilkan koleksi.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        </div>
    </section>
@endsection
