@php
    use Illuminate\Support\Str;
@endphp

@extends('storefront.layouts.app')

@section('title', 'Nstore - Nike Sneaker Hub')

@php
    $heroSlides = collect([$heroProduct])->filter()->merge($highlightProducts)->unique('id')->values();
    $heroSlidesPayload = $heroSlides->map(fn ($product) => [
        'name' => $product->name,
        'brand' => $product->brand,
        'category' => optional($product->category)->name,
        'description' => $product->short_description,
        'slug' => $product->slug,
    ]);
@endphp

@section('content')
    <section class="relative -mt-20 overflow-hidden bg-brand-white pt-20" data-hero-section data-hero-slides='@json($heroSlidesPayload)' data-product-url="{{ url('products') }}">
        <div class="absolute inset-0">
            <div class="h-full w-full bg-cover bg-center" style="background-image: url('{{ Vite::asset('resources/images/home-hero.jpg') }}');"></div>
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
        <div class="relative mx-auto flex w-full max-w-6xl flex-col gap-10 px-6 py-24 text-brand-white lg:flex-row lg:items-center">
            <div class="hero-content max-w-xl" data-hero-content data-aos="fade-right" data-aos-delay="100">
                <span class="text-xs font-semibold uppercase tracking-[0.4em] text-brand-white/80" data-hero-category>{{ $heroProduct?->category->name ?? $heroProduct?->brand ?? 'Nike Sneaker Collection' }}</span>
                <h1 class="mt-4 text-4xl font-bold leading-tight tracking-tight sm:text-5xl">
                    <span data-hero-name>{{ $heroProduct?->name ?? 'Step Into The Future' }}</span><br>
                    <span data-hero-tagline>{{ $heroProduct?->brand ? 'by '.$heroProduct->brand : 'with Nstore' }}</span>
                </h1>
                <p class="mt-6 text-sm text-brand-white/80" data-hero-description>{{ $heroProduct?->short_description ?? 'Koleksi eksklusif Nike pilihan terbaru, mulai dari seri Air Jordan hingga Next% runner. Semua dalam satu tempat dengan pengalaman belanja yang clean dan cepat.' }}</p>
                <div class="mt-10 flex flex-wrap gap-4 text-sm font-semibold">
                    <a href="{{ $heroProduct ? route('storefront.product.show', $heroProduct->slug) : '#koleksi' }}" data-hero-cta class="rounded-full bg-brand-white px-6 py-2 text-brand-black transition hover:bg-brand-darkGray hover:text-brand-white">{{ $heroProduct ? 'Lihat Produk' : 'Shop Koleksi' }}</a>
                    <a href="#best-seller" class="rounded-full border border-brand-white px-6 py-2 transition hover:bg-brand-white hover:text-brand-black">Lihat Best Seller</a>
                </div>
            </div>
            <div class="flex-1" data-aos="fade-left" data-aos-delay="200">
                <div class="rounded-3xl border border-brand-white/30 bg-brand-white/10 p-6 backdrop-blur">
                    <h2 class="text-lg font-semibold uppercase tracking-tight text-brand-white">Highlight Minggu Ini</h2>
                    <div class="mt-4 space-y-4 text-sm text-brand-white/80">
                        @forelse ($highlightProducts as $product)
                            <article class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 transition duration-300 hover:border-white/30 hover:bg-white/10" data-aos="fade-up" data-aos-delay="{{ 250 + ($loop->index * 100) }}">
                                <div>
                                    <div class="text-[11px] font-semibold uppercase tracking-[0.4em] text-brand-white/60">{{ $product->category->name ?? $product->brand ?? 'Nike' }}</div>
                                    <h3 class="mt-1 text-base font-semibold text-brand-white">{{ $product->name }}</h3>
                                    @if ($product->short_description)
                                        <p class="mt-1 text-xs text-brand-white/70">{{ Str::limit($product->short_description, 80) }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('storefront.product.show', $product->slug) }}" class="rounded-full border border-brand-white/50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-white transition hover:bg-brand-white hover:text-brand-black">Detail</a>
                            </article>
                        @empty
                            <div class="rounded-2xl border border-dashed border-white/30 bg-white/10 p-4 text-sm text-brand-white/70">Belum ada highlight untuk ditampilkan.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="pointer-events-none absolute inset-x-0 bottom-6 flex justify-center">
            <div class="flex flex-col items-center gap-2 text-xs font-semibold uppercase tracking-[0.4em] text-brand-white/70">
                <span>Scroll untuk eksplor</span>
                <span class="animate-bounce text-base">↓</span>
            </div>
        </div>
    </section>

    <section id="koleksi" class="mx-auto w-full max-w-6xl px-6 py-16" data-aos="fade-up" data-aos-offset="200">
        <div class="flex flex-col gap-6">
            <div class="flex flex-wrap items-center justify-between gap-4" data-aos="fade-up" data-aos-delay="100">
                <div>
                    <h2 class="text-2xl font-semibold">Koleksi Terbaru</h2>
                    <p class="mt-2 text-sm text-brand-darkGray">Curated sneakers buat kamu yang selalu update style.</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('storefront.catalog') }}" class="text-xs font-semibold uppercase tracking-[0.4em] text-brand-darkGray transition hover:text-brand-black">View All</a>
                    <div class="flex gap-2 text-lg">
                        <button id="collection-prev" class="slider-nav-pill" aria-label="Produk sebelumnya">⟵</button>
                        <button id="collection-next" class="slider-nav-pill" aria-label="Produk selanjutnya">⟶</button>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden" id="collection-track">
                <div class="flex gap-6 transition-transform duration-500" data-collection-items>
                    @forelse ($featuredProducts as $product)
                        <article class="group flex min-w-[260px] max-w-[320px] flex-1 flex-col overflow-hidden rounded-3xl border border-brand-black/5 bg-brand-white shadow-sm shadow-black/5 transition duration-300 hover:-translate-y-1 hover:shadow-xl md:min-w-[300px]" data-aos="fade-up" data-aos-delay="{{ 150 + ($loop->index * 80) }}">
                            <div class="relative aspect-[4/3] overflow-hidden bg-brand-gray/60">
                                <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                <span class="absolute left-4 top-4 rounded-full bg-brand-black px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-white">{{ $product->category->name ?? $product->brand ?? 'Nike' }}</span>
                            </div>
                            <div class="flex flex-1 flex-col px-6 py-5">
                                <div class="text-[11px] uppercase tracking-[0.3em] text-brand-darkGray">{{ $product->brand ?? 'Nike' }}</div>
                                <h3 class="mt-2 text-lg font-semibold text-brand-black">{{ $product->name }}</h3>
                                @if ($product->short_description)
                                    <p class="mt-3 flex-1 text-sm text-brand-darkGray">{{ Str::limit($product->short_description, 90) }}</p>
                                @endif
                                <div class="mt-6 flex items-center justify-between">
                                    <div class="text-lg font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    <a href="{{ route('storefront.product.show', $product->slug) }}" class="inline-flex items-center gap-1 text-xs font-semibold uppercase tracking-[0.3em] text-brand-black transition hover:text-brand-darkGray">
                                        Detail
                                        <span class="text-[10px]">→</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="min-w-full rounded-3xl border border-dashed border-brand-black/10 bg-brand-gray/40 p-12 text-center text-sm text-brand-darkGray">
                            Produk belum tersedia di katalog. Tambahkan produk melalui panel admin untuk menampilkan koleksi terbaru di sini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section id="best-seller" class="bg-brand-black py-16 text-brand-white" data-aos="fade-up" data-aos-offset="200">
        <div class="mx-auto flex w-full max-w-6xl flex-col gap-10 px-6 lg:flex-row lg:items-center">
            <div class="max-w-lg" data-aos="fade-right" data-aos-delay="100">
                <h2 class="text-2xl font-semibold">Best Seller Bulan Ini</h2>
                <p class="mt-3 text-sm text-brand-white/70">Sneakers yang paling banyak diburu komunitas. Dipilih berdasarkan penjualan dan rating pengguna.</p>
                <a href="{{ route('storefront.catalog') }}" class="mt-6 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-white transition hover:text-brand-gray">Lihat Katalog</a>
            </div>
            <div class="flex-1" data-aos="fade-left" data-aos-delay="200">
                <div class="grid gap-6 md:grid-cols-2">
                    @foreach ($bestSellers as $product)
                        <article class="flex flex-col gap-4 rounded-2xl border border-brand-white/10 bg-brand-white/5 p-6" data-aos="fade-up" data-aos-delay="{{ 200 + ($loop->index * 80) }}">
                            <div class="flex items-start justify-between">
                                <span class="text-xs uppercase tracking-[0.3em] text-brand-white/70">{{ $product->brand }}</span>
                                <span class="rounded-full bg-brand-white/10 px-3 py-1 text-xs">#{{ $loop->iteration }}</span>
                            </div>
                            <h3 class="text-lg font-semibold text-brand-white">{{ $product->name }}</h3>
                            <div class="text-sm text-brand-white/70">{{ Str::limit($product->short_description, 80) }}</div>
                            <div class="mt-auto flex items-center justify-between">
                                <div class="text-lg font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <a href="{{ route('storefront.product.show', $product->slug) }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-white transition hover:text-brand-gray">Detail</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="mx-auto w-full max-w-6xl px-6 py-16" data-aos="fade-up" data-aos-offset="200">
        <div class="grid gap-10 md:grid-cols-2 md:items-center">
            <div data-aos="fade-right" data-aos-delay="100">
                <h2 class="text-2xl font-semibold">Kenapa Nstore?</h2>
                <p class="mt-3 text-sm text-brand-darkGray">Nstore lahir untuk para sneakerheads yang haus rilisan terbaru dengan experience belanja yang clean dan premium. Semua produk kami curated langsung, memastikan kualitas prima.</p>
                <ul class="mt-6 space-y-4 text-sm text-brand-darkGray">
                    <li class="flex items-start gap-3">
                        <span class="mt-1 block h-2 w-2 rounded-full bg-brand-black"></span>
                        <span>100% Nike original dengan sertifikat digital.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 block h-2 w-2 rounded-full bg-brand-black"></span>
                        <span>Pilihan ukuran lengkap dari US 6 sampai 13.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 block h-2 w-2 rounded-full bg-brand-black"></span>
                        <span>Pengiriman express dan opsi same-day untuk wilayah Jabodetabek.</span>
                    </li>
                </ul>
            </div>
            <div class="rounded-3xl border border-brand-black/10 bg-brand-gray p-8" data-aos="fade-left" data-aos-delay="200">
                <h3 class="text-lg font-semibold">Join komunitas Nstore</h3>
                <p class="mt-3 text-sm text-brand-darkGray">Dapatkan early access launch, diskon member, dan undangan event eksklusif.</p>
                <form class="mt-6 flex flex-col gap-4 md:flex-row">
                    <input type="email" placeholder="Email kamu" class="w-full rounded-full border border-brand-black/10 bg-brand-white px-5 py-3 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20" />
                    <button type="button" class="rounded-full bg-brand-black px-6 py-3 text-sm font-semibold text-brand-white transition hover:bg-brand-darkGray">Daftar</button>
                </form>
            </div>
        </div>
    </section>
@endsection
