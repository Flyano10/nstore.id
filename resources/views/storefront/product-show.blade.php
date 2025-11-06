@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('storefront.layouts.app')

@section('title', $product->name . ' - Nstore')

@php
    $defaultSizeId = old('size_id');

    if ($defaultSizeId === null) {
        $defaultSizeId = optional($product->sizes->firstWhere('stock', '>', 0))->id;
    }
@endphp

@section('content')
    <section class="bg-brand-white py-16">
        <div class="mx-auto w-full max-w-6xl px-6">
            <a href="{{ route('storefront.catalog') }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray transition hover:text-brand-black">← Kembali ke katalog</a>

            <div class="mt-10 grid gap-10 lg:grid-cols-2 lg:items-start">
                <div class="space-y-6">
                    <div class="overflow-hidden rounded-3xl border border-brand-black/5 bg-brand-gray/60">
                        <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                    </div>
                    @if ($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach ($product->images->skip(1) as $image)
                                <div class="overflow-hidden rounded-2xl border border-brand-black/5 bg-brand-gray/60">
                                    <img src="{{ Str::startsWith($image->path, ['http://', 'https://']) ? $image->path : Storage::url($image->path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="space-y-8">
                    <div>
                        <span class="text-xs uppercase tracking-[0.3em] text-brand-darkGray">{{ $product->brand }}</span>
                        <h1 class="mt-3 text-3xl font-semibold">{{ $product->name }}</h1>
                        <p class="mt-4 text-sm text-brand-darkGray">{{ $product->short_description }}</p>
                    </div>

                    <div class="space-y-4">
                        <div class="text-3xl font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        @if ($product->compare_at_price)
                            <div class="text-sm text-brand-darkGray line-through">Rp {{ number_format($product->compare_at_price, 0, ',', '.') }}</div>
                        @endif
                    </div>

                    <form action="{{ route('storefront.cart.store') }}" method="POST" class="space-y-6 rounded-3xl border border-brand-black/10 bg-brand-gray/60 p-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        @if ($product->sizes->isNotEmpty())
                            <div class="space-y-3">
                                <h2 class="text-sm font-semibold uppercase tracking-[0.3em]">Pilih Ukuran</h2>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($product->sizes as $size)
                                        <label class="cursor-pointer rounded-full border px-4 py-2 text-xs font-semibold uppercase tracking-wide {{ $size->stock > 0 ? 'border-brand-black/30 bg-brand-white text-brand-black transition hover:bg-brand-black hover:text-brand-white' : 'cursor-not-allowed border-brand-darkGray/20 bg-brand-gray text-brand-darkGray' }}">
                                            <input type="radio" name="size_id" value="{{ $size->id }}" class="sr-only" {{ (string) $defaultSizeId === (string) $size->id ? 'checked' : '' }} {{ $size->stock <= 0 ? 'disabled' : '' }}>
                                            <span>{{ $size->size }}</span>
                                            @if ($size->stock <= 0)
                                                <span class="ml-1 text-[10px]">(Habis)</span>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="size_id" value="">
                        @endif

                        <div class="space-y-2">
                            <label for="quantity" class="text-xs font-semibold uppercase tracking-[0.3em]">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" class="w-32 rounded-full border border-brand-black/20 bg-brand-white px-4 py-2 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20">
                        </div>

                        <div class="space-y-4 text-sm text-brand-darkGray">
                            <h2 class="text-sm font-semibold uppercase tracking-[0.3em]">Deskripsi</h2>
                            <div class="prose prose-sm max-w-none text-brand-darkGray">
                                {!! nl2br(e($product->description ?? $product->short_description)) !!}
                            </div>
                        </div>

                        <button type="submit" class="w-full rounded-full bg-brand-black px-6 py-3 text-sm font-semibold text-brand-white transition hover:bg-brand-darkGray">Tambah ke Keranjang</button>
                    </form>
                </div>
            </div>

            @if ($relatedProducts->isNotEmpty())
                <section class="mt-16">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-semibold">Kamu Mungkin Juga Suka</h2>
                        <a href="{{ route('storefront.catalog') }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray transition hover:text-brand-black">Lihat Semua</a>
                    </div>
                    <div class="mt-8 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                        @foreach ($relatedProducts as $related)
                            <article class="group flex flex-col overflow-hidden rounded-3xl border border-brand-black/5 bg-brand-white shadow-sm shadow-black/5">
                                <div class="relative aspect-square overflow-hidden bg-brand-gray/60">
                                    <img src="{{ $related->featured_image_url }}" alt="{{ $related->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                </div>
                                <div class="flex flex-1 flex-col px-6 py-5">
                                    <span class="text-xs uppercase tracking-[0.3em] text-brand-darkGray">{{ $related->brand }}</span>
                                    <h3 class="mt-2 text-lg font-semibold text-brand-black">{{ $related->name }}</h3>
                                    <div class="mt-4 text-lg font-semibold">Rp {{ number_format($related->price, 0, ',', '.') }}</div>
                                    <a href="{{ route('storefront.product.show', $related->slug) }}" class="mt-4 text-xs font-semibold uppercase tracking-[0.3em] text-brand-black transition hover:text-brand-darkGray">Detail</a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>
@endsection
