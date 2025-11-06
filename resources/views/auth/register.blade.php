<x-guest-layout>
    <div class="space-y-8">
        <div class="space-y-3">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-brand-darkGray">Gabung komunitas</p>
            <h2 class="text-3xl font-semibold leading-tight text-brand-black">Daftar member baru Nstore</h2>
            <p class="text-sm text-brand-darkGray">Buat akun untuk simpan wishlist, akses promo eksklusif, dan nikmatin update rilisan terbaru.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="name" class="text-sm font-semibold uppercase tracking-[0.2em] text-brand-darkGray">Nama lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="w-full rounded-2xl border border-brand-black/10 bg-white px-5 py-3 text-sm font-medium text-brand-black shadow-sm transition focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/15" />
                @error('name')
                    <p class="text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="email" class="text-sm font-semibold uppercase tracking-[0.2em] text-brand-darkGray">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="w-full rounded-2xl border border-brand-black/10 bg-white px-5 py-3 text-sm font-medium text-brand-black shadow-sm transition focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/15" />
                @error('email')
                    <p class="text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm font-semibold uppercase tracking-[0.2em] text-brand-darkGray">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="w-full rounded-2xl border border-brand-black/10 bg-white px-5 py-3 text-sm font-medium text-brand-black shadow-sm transition focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/15" />
                @error('password')
                    <p class="text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="text-sm font-semibold uppercase tracking-[0.2em] text-brand-darkGray">Konfirmasi password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="w-full rounded-2xl border border-brand-black/10 bg-white px-5 py-3 text-sm font-medium text-brand-black shadow-sm transition focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/15" />
                @error('password_confirmation')
                    <p class="text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-brand-black px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-brand-white transition hover:bg-brand-darkGray">
                Daftar sekarang
            </button>
        </form>

        <div class="rounded-2xl border border-brand-black/10 bg-brand-gray p-5 text-center text-sm text-brand-darkGray">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-brand-black underline-offset-4 hover:underline">Masuk di sini</a>
        </div>
    </div>
</x-guest-layout>
