@php
    use Illuminate\Support\Str;
@endphp

@extends('admin.layouts.app')

@section('title', 'Produk')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold">Daftar Produk</h2>
            <p class="mt-1 text-sm text-brand-darkGray">Kelola katalog sepatu Nike kamu beserta stok dan ukurannya.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="rounded-full bg-brand-black px-5 py-2 text-sm font-semibold text-brand-white transition hover:bg-brand-darkGray">Tambah Produk</a>
    </div>

    <div class="rounded-2xl bg-brand-white shadow-sm shadow-black/5">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[920px] text-left text-sm">
                <thead>
                    <tr class="border-b border-brand-gray text-xs uppercase tracking-wide text-brand-darkGray">
                        <th class="px-6 py-4 font-semibold">Produk</th>
                        <th class="px-6 py-4 font-semibold">Kategori</th>
                        <th class="px-6 py-4 font-semibold">Harga</th>
                        <th class="px-6 py-4 font-semibold">Stok Total</th>
                        <th class="px-6 py-4 font-semibold">Aktif</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-gray/70">
                    @forelse ($products as $product)
                        <tr class="hover:bg-brand-gray/60">
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $product->name }}</div>
                                <div class="text-xs text-brand-darkGray">SKU: {{ $product->sku }}</div>
                                @if ($product->short_description)
                                    <div class="mt-1 text-xs text-brand-darkGray">{{ Str::limit($product->short_description, 80) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-darkGray">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-brand-darkGray">{{ $product->sizes->sum('stock') }} pcs</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $product->is_active ? 'bg-brand-black text-brand-white' : 'bg-brand-gray text-brand-darkGray' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="rounded-full border border-brand-black/10 px-4 py-1.5 text-xs font-semibold text-brand-black transition hover:bg-brand-gray">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-full border border-red-300 px-4 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-brand-darkGray">Belum ada produk terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-brand-gray/70 px-6 py-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
