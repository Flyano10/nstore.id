<x-guest-layout>
    <div class="space-y-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="space-y-3">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-brand-darkGray">Selamat datang kembali</p>
            <h2 class="text-3xl font-semibold leading-tight text-brand-black">Masuk ke akun Nstore kamu</h2>
            <p class="text-sm text-brand-darkGray">Login untuk cek status pesanan, lanjutkan checkout, dan dapetin notifikasi restock.</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="email" class="text-sm font-semibold uppercase tracking-[0.2em] text-brand-darkGray">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full rounded-2xl border border-brand-black/10 bg-white px-5 py-3 text-sm font-medium text-brand-black shadow-sm transition focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/15" />
                @error('email')
                    <p class="text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm font-semibold uppercase tracking-[0.2em] text-brand-darkGray">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full rounded-2xl border border-brand-black/10 bg-white px-5 py-3 text-sm font-medium text-brand-black shadow-sm transition focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/15" />
                @error('password')
                    <p class="text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center gap-3 text-xs font-medium uppercase tracking-[0.2em] text-brand-darkGray">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 rounded border-brand-black/30 text-brand-black focus:ring-brand-black/40" />
                    Ingat saya
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-black transition hover:text-brand-darkGray">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-brand-black px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-brand-white transition hover:bg-brand-darkGray">
                Masuk sekarang
            </button>
        </form>

        @if (Route::has('register'))
            <div class="rounded-2xl border border-brand-black/10 bg-brand-gray p-5 text-center text-sm text-brand-darkGray">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-brand-black underline-offset-4 hover:underline">Daftar member baru</a>
            </div>
        @endif
    </div>
</x-guest-layout>
