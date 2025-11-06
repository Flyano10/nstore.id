<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} — Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-gray text-brand-black font-sans antialiased">
    <div class="min-h-screen flex">
        @include('admin.partials.sidebar')

        <div class="flex-1 flex flex-col">
            <header class="flex items-center justify-between border-b border-brand-darkGray/10 bg-brand-white px-6 py-4">
                <div>
                    <h1 class="text-lg font-semibold tracking-tight">@yield('title', 'Dashboard')</h1>
                    @hasSection('breadcrumbs')
                        <div class="mt-1 text-sm text-brand-darkGray">@yield('breadcrumbs')</div>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium">{{ auth()->user()->name ?? 'Administrator' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full bg-brand-black px-4 py-2 text-sm font-semibold text-brand-white transition hover:bg-brand-darkGray">Keluar</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto px-6 py-8">
                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-brand-black/10 bg-brand-white px-4 py-3 text-sm font-medium text-brand-black shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-semibold">Terjadi kesalahan:</p>
                        <ul class="mt-2 list-disc space-y-1 ps-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
