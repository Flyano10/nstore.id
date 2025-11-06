<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-brand-black font-sans text-brand-black antialiased">
        <div class="relative min-h-screen overflow-hidden">
            <div class="absolute inset-0 -z-10">
                <div class="h-full w-full bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.18)_0%,_rgba(0,0,0,0.9)_65%)]"></div>
                <div class="absolute inset-0">
                    <img src="{{ Vite::asset('resources/images/home-hero.jpg') }}" alt="Nstore background" class="h-full w-full object-cover opacity-30" />
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-xl"></div>
                </div>
            </div>

            <div class="relative mx-auto flex min-h-screen w-full max-w-4xl items-center justify-center px-5 py-12">
                <div class="flex w-full flex-col overflow-hidden rounded-[2rem] border border-white/10 bg-white/85 text-brand-black shadow-[0_24px_80px_-40px_rgba(0,0,0,0.85)] backdrop-blur-xl md:flex-row">
                    <div class="flex flex-col gap-7 bg-brand-black/90 p-8 text-brand-white md:max-w-xs" data-aos="fade-right">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-semibold uppercase tracking-[0.3em]">
                                <img src="{{ Vite::asset('resources/images/logo-nike.png') }}" alt="Logo Nike" class="h-6 w-6 object-contain" />
                                <span class="h-6 w-px bg-white/20"></span>
                                <img src="{{ Vite::asset('resources/images/logo-air.png') }}" alt="Logo Air" class="h-6 w-6 object-contain" />
                            </span>
                        </div>

                        <div class="space-y-3">
                            <h1 class="text-2xl font-semibold leading-tight">Masuk ke ekosistem <span class="text-brand-white/70">Nstore</span></h1>
                            <p class="text-xs text-brand-white/70">Kelola pesanan, pantau rilisan terbaru, dan dapatkan akses early drop hanya dengan satu akun.</p>
                        </div>

                        <ul class="space-y-2 text-xs text-brand-white/60">
                            <li class="flex items-center gap-2">
                                <span class="inline-flex h-2 w-2 rounded-full bg-brand-white"></span>
                                Simpan wishlist sneakers favorit kamu.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="inline-flex h-2 w-2 rounded-full bg-brand-white"></span>
                                Notifikasi restock real-time langsung ke email.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="inline-flex h-2 w-2 rounded-full bg-brand-white"></span>
                                Akses promo eksklusif member Nstore Club.
                            </li>
                        </ul>

                        <div class="mt-auto text-[10px] uppercase tracking-[0.35em] text-brand-white/50">Stay fly, stay ahead.</div>
                    </div>

                    <div class="flex-1 bg-white/92 px-7 py-9 sm:px-10 md:px-12" data-aos="fade-left">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
