<aside class="w-64 bg-brand-black text-brand-white flex flex-col">
    <div class="px-6 py-4 border-b border-white/10">
        <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold tracking-tight uppercase">Nstore Admin</a>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 text-sm font-medium">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between rounded-lg px-3 py-2 transition hover:bg-brand-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-white/10' : '' }}">
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="flex items-center justify-between rounded-lg px-3 py-2 transition hover:bg-brand-white/10 {{ request()->routeIs('admin.categories.*') ? 'bg-brand-white/10' : '' }}">
            <span>Kategori</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between rounded-lg px-3 py-2 transition hover:bg-brand-white/10 {{ request()->routeIs('admin.products.*') ? 'bg-brand-white/10' : '' }}">
            <span>Produk</span>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between rounded-lg px-3 py-2 transition hover:bg-brand-white/10 {{ request()->routeIs('admin.orders.*') ? 'bg-brand-white/10' : '' }}">
            <span>Pesanan</span>
        </a>
    </nav>
</aside>
