<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Nstore') }}</title>

        <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-brand-white font-sans text-brand-black antialiased">
        @php
            $cartCount = collect(session('cart', []))->sum('quantity');
            $currentUser = auth()->user();
        @endphp

        <div class="flex min-h-screen flex-col">
            <header id="storefront-header" class="site-header header-transparent fixed inset-x-0 top-0 z-50 transition duration-500">
                <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-3 px-6 py-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 text-lg font-semibold tracking-tight uppercase">
                        <span class="logo-badge flex items-center gap-2 rounded-full border border-brand-black/10 bg-brand-gray/60 px-3 py-1 transition duration-300">
                            <img src="{{ Vite::asset('resources/images/logo-nike.png') }}" alt="Logo Nike" class="h-6 w-6 object-contain">
                            <span class="h-6 w-px bg-current/20"></span>
                            <img src="{{ Vite::asset('resources/images/logo-air.png') }}" alt="Logo Air" class="h-6 w-6 object-contain">
                        </span>
                        <span class="hidden text-base font-semibold tracking-[0.3em] sm:inline">Nstore</span>
                    </a>

                    <nav class="hidden items-center gap-6 md:flex">
                        <a href="{{ route('home') }}#koleksi" class="nav-link">
                            <span class="nav-link-label">Koleksi</span>
                        </a>
                        <a href="{{ route('home') }}#best-seller" class="nav-link">
                            <span class="nav-link-label">Best Seller</span>
                        </a>
                        <a href="{{ route('home') }}#about" class="nav-link">
                            <span class="nav-link-label">Tentang</span>
                        </a>
                        <a href="{{ route('storefront.catalog') }}" class="nav-link {{ request()->routeIs('storefront.catalog') ? 'is-active' : '' }}">
                            <span class="nav-link-label">Catalog</span>
                        </a>
                    </nav>

                    <div class="hidden items-center gap-3 md:flex">
                        <a href="{{ route('storefront.cart.index') }}" class="header-pill">
                            Keranjang
                            @if ($cartCount > 0)
                                <span class="ml-2 inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-brand-black px-1 text-[11px] font-bold text-brand-white">{{ $cartCount }}</span>
                            @endif
                        </a>
                        @auth
                            @if ($currentUser?->is_admin)
                                <a href="{{ route('dashboard') }}" class="header-pill">Dashboard</a>
                            @else
                                <a href="{{ route('storefront.orders.index') }}" class="header-pill {{ request()->routeIs('storefront.orders.*') ? 'is-active-pill' : '' }}">Pesanan</a>
                            @endif

                            <form action="{{ route('logout') }}" method="POST" class="contents">
                                @csrf
                                <button type="submit" class="header-pill">Keluar</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="header-pill">Masuk</a>
                        @endauth
                    </div>

                    <div class="flex items-center gap-2 md:hidden">
                        <a href="{{ route('storefront.cart.index') }}" class="header-pill px-4 py-2 text-[0.65rem]">
                            Keranjang
                            @if ($cartCount > 0)
                                <span class="ml-1 inline-flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-brand-black px-1 text-[10px] font-bold text-brand-white">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <button type="button" class="header-pill px-4 py-2 text-[0.65rem]" data-mobile-toggle aria-expanded="false" aria-controls="mobile-nav">
                            Menu
                        </button>
                    </div>
                </div>

                <div id="mobile-nav" class="mobile-nav md:hidden" data-mobile-nav>
                    <nav class="space-y-2">
                        <a href="{{ route('home') }}#koleksi" class="mobile-nav-link" data-mobile-close>Koleksi Terbaru</a>
                        <a href="{{ route('home') }}#best-seller" class="mobile-nav-link" data-mobile-close>Best Seller</a>
                        <a href="{{ route('home') }}#about" class="mobile-nav-link" data-mobile-close>Tentang Nstore</a>
                        <a href="{{ route('storefront.catalog') }}" class="mobile-nav-link" data-mobile-close>Catalog</a>
                    </nav>

                    <div class="mt-6 space-y-3 border-t border-white/10 pt-6 text-sm text-brand-white/70">
                        @auth
                            @if ($currentUser?->is_admin)
                                <a href="{{ route('dashboard') }}" class="mobile-nav-link" data-mobile-close>Dashboard</a>
                            @else
                                <a href="{{ route('storefront.orders.index') }}" class="mobile-nav-link" data-mobile-close>Pesanan</a>
                            @endif

                            <form action="{{ route('logout') }}" method="POST" class="pt-2" data-mobile-close>
                                @csrf
                                <button type="submit" class="w-full rounded-full border border-white/20 px-5 py-3 text-xs font-semibold uppercase tracking-[0.3em] text-brand-white transition hover:bg-brand-white hover:text-brand-black">Keluar</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="mobile-nav-link" data-mobile-close>Masuk</a>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="flex-1 pt-20">
                @if (session('status'))
                    <div class="border-b border-brand-black/10 bg-brand-white">
                        <div class="mx-auto w/full max-w-4xl px-6 py-4 text-sm font-medium text-brand-black">{{ session('status') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="border-b border-red-200 bg-red-50">
                        <div class="mx-auto w-full max-w-4xl px-6 py-4 text-sm text-red-600">
                            <ul class="list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="bg-brand-black text-brand-white" data-aos="fade-up" data-aos-offset="100">
                <div class="mx-auto w-full max-w-6xl px-6 py-16">
                    <div class="grid gap-10 lg:grid-cols-[1.5fr_repeat(3,1fr)]">
                        <div class="space-y-6">
                            <div class="inline-flex items-center gap-3">
                                <img src="{{ Vite::asset('resources/images/nike-footer.png') }}" alt="Nike Swoosh" class="h-10 w-auto">
                                <div>
                                    <p class="text-sm uppercase tracking-[0.4em] text-brand-white/60">Nstore</p>
                                    <p class="mt-1 text-sm text-brand-white/70">Hub sneakers resmi Nike dengan kurasi rilisan terbaru untuk komunitas Indonesia.</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <a href="https://instagram.com" target="_blank" rel="noopener" class="footer-social" aria-label="Instagram">
                                    <span class="text-lg">IG</span>
                                </a>
                                <a href="https://tiktok.com" target="_blank" rel="noopener" class="footer-social" aria-label="TikTok">
                                    <span class="text-lg">TT</span>
                                </a>
                                <a href="https://youtube.com" target="_blank" rel="noopener" class="footer-social" aria-label="YouTube">
                                    <span class="text-lg">YT</span>
                                </a>
                                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="footer-social" aria-label="WhatsApp">
                                    <span class="text-lg">WA</span>
                                </a>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <p class="text-xs uppercase tracking-[0.35em] text-brand-white/60">Navigasi</p>
                            <nav class="flex flex-col gap-2">
                                <a href="{{ route('home') }}#koleksi" class="footer-link">Koleksi Terbaru</a>
                                <a href="{{ route('home') }}#best-seller" class="footer-link">Best Seller</a>
                                <a href="{{ route('home') }}#about" class="footer-link">Tentang Nstore</a>
                                <a href="{{ route('storefront.catalog') }}" class="footer-link">Catalog</a>
                            </nav>
                        </div>

                        <div class="space-y-3">
                            <p class="text-xs uppercase tracking-[0.35em] text-brand-white/60">Butuh Bantuan?</p>
                            <ul class="space-y-2 text-sm text-brand-white/70">
                                <li>Email: <a href="mailto:support@nstore.co" class="footer-link">support@nstore.co</a></li>
                                <li>Hotline: <a href="tel:+622112345678" class="footer-link">+62 21 1234 5678</a></li>
                                <li>Jam operasional: 09.00 - 21.00 WIB</li>
                            </ul>
                        </div>

                        <div class="space-y-4">
                            <p class="text-xs uppercase tracking-[0.35em] text-brand-white/60">Newsletter</p>
                            <p class="text-sm text-brand-white/70">Masuk ke daftar prioritas buat dapetin early drop, restock alert, dan kode diskon eksklusif.</p>
                            <form class="flex flex-col gap-3 sm:flex-row">
                                <input type="email" name="footer_email" placeholder="Email kamu" class="w-full rounded-full border border-white/20 bg-transparent px-5 py-3 text-sm text-brand-white placeholder:text-brand-white/50 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/40" />
                                <button type="button" class="rounded-full bg-brand-white px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-brand-black transition hover:bg-brand-gray">Daftar</button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-12 flex flex-col gap-4 border-t border-white/10 pt-6 text-xs text-brand-white/50 lg:flex-row lg:items-center lg:justify-between">
                        <p>© {{ date('Y') }} Nstore. All rights reserved.</p>
                        <div class="flex flex-wrap gap-4">
                            <a href="#" class="footer-link text-xs">Privacy Policy</a>
                            <a href="#" class="footer-link text-xs">Terms & Conditions</a>
                            <a href="#" class="footer-link text-xs">Cookie Settings</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
        @vite('resources/js/collections.js')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (typeof AOS !== 'undefined') {
                    AOS.init({
                        duration: 700,
                        once: false,
                        easing: 'ease-out-cubic',
                    });
                }

                const header = document.getElementById('storefront-header');
                const hero = document.querySelector('[data-hero-section]');

                if (!header) {
                    return;
                }

                const toggleHeader = () => {
                    if (!hero) {
                        header.classList.remove('header-transparent');
                        header.classList.add('header-solid');
                        return;
                    }

                    const threshold = hero.offsetHeight - 100;
                    if (window.scrollY > threshold) {
                        header.classList.remove('header-transparent');
                        header.classList.add('header-solid');
                    } else {
                        header.classList.add('header-transparent');
                        header.classList.remove('header-solid');
                    }
                };

                toggleHeader();
                window.addEventListener('scroll', toggleHeader, { passive: true });

                const collectionItems = document.querySelector('[data-collection-items]');
                const collectionPrev = document.getElementById('collection-prev');
                const collectionNext = document.getElementById('collection-next');
                if (collectionItems && collectionPrev && collectionNext) {
                    let index = 0;

                    const updateCollectionSlider = () => {
                        const containerWidth = collectionItems.offsetWidth;
                        const firstItem = collectionItems.children[0];
                        if (!firstItem) {
                            return;
                        }

                        const itemWidth = firstItem.offsetWidth;
                        const gap = parseFloat(getComputedStyle(collectionItems).gap || '24');
                        const visibleWidth = collectionItems.parentElement?.offsetWidth ?? itemWidth;
                        const itemsPerView = Math.max(Math.floor((visibleWidth + gap) / (itemWidth + gap)), 1);
                        const maxIndex = Math.max(collectionItems.children.length - itemsPerView, 0);

                        if (index > maxIndex) {
                            index = maxIndex;
                        }

                        const offset = (itemWidth + gap) * index * -1;
                        collectionItems.style.transform = `translateX(${offset}px)`;

                        collectionPrev.disabled = index === 0;
                        collectionNext.disabled = index >= maxIndex;
                    };

                    collectionPrev.addEventListener('click', () => {
                        index = Math.max(index - 1, 0);
                        updateCollectionSlider();
                    });

                    collectionNext.addEventListener('click', () => {
                        index = index + 1;
                        updateCollectionSlider();
                    });

                    window.addEventListener('resize', updateCollectionSlider);
                    updateCollectionSlider();
                }

                const heroSection = document.querySelector('[data-hero-section]');
                const heroContent = document.querySelector('[data-hero-content]');
                const heroCategory = document.querySelector('[data-hero-category]');
                const heroName = document.querySelector('[data-hero-name]');
                const heroTagline = document.querySelector('[data-hero-tagline]');
                const heroDescription = document.querySelector('[data-hero-description]');
                const heroCta = document.querySelector('[data-hero-cta]');

                if (heroSection && heroContent && heroCategory && heroName && heroTagline && heroDescription && heroCta) {
                    const rawSlides = heroSection.getAttribute('data-hero-slides');
                    const baseProductUrl = heroSection.getAttribute('data-product-url');
                    let slides = [];

                    try {
                        slides = JSON.parse(rawSlides || '[]').filter(slide => slide?.slug);
                    } catch (error) {
                        console.warn('Gagal memuat hero slides', error);
                    }

                    if (slides.length > 1) {
                        let cursor = 0;

                        const playNext = () => {
                            cursor = (cursor + 1) % slides.length;
                            const slide = slides[cursor];

                            heroContent.classList.add('is-fading');

                            setTimeout(() => {
                                heroCategory.textContent = slide.category || slide.brand || 'Nstore Drop';
                                heroName.textContent = slide.name;
                                heroTagline.textContent = slide.brand ? `by ${slide.brand}` : 'with Nstore';
                                heroDescription.textContent = slide.description || 'Temukan rilisan terbaru kami.';
                                heroCta.setAttribute('href', `${baseProductUrl}/${slide.slug}`);
                                heroCta.textContent = 'Lihat Produk';

                                heroContent.classList.remove('is-fading');
                            }, 300);
                        };

                        setInterval(playNext, 6000);
                    }
                }

                const mobileToggle = document.querySelector('[data-mobile-toggle]');
                const mobileNav = document.querySelector('[data-mobile-nav]');
                const mobileCloseTargets = document.querySelectorAll('[data-mobile-close]');

                let mobileOpen = false;

                const setMobileState = (nextState) => {
                    mobileOpen = nextState;

                    if (mobileToggle) {
                        mobileToggle.setAttribute('aria-expanded', mobileOpen ? 'true' : 'false');
                    }

                    if (mobileNav) {
                        mobileNav.classList.toggle('is-open', mobileOpen);
                    }
                };

                if (mobileToggle && mobileNav) {
                    mobileToggle.addEventListener('click', () => {
                        setMobileState(!mobileOpen);
                    });

                    mobileCloseTargets.forEach((target) => {
                        target.addEventListener('click', () => setMobileState(false));
                    });

                    document.addEventListener('keydown', (event) => {
                        if (event.key === 'Escape') {
                            setMobileState(false);
                        }
                    });

                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 768) {
                            setMobileState(false);
                        }
                    });
                }
            });
        </script>
    </body>
</html>
