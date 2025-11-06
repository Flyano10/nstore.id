@extends('admin.layouts.app')

@section('title', 'Kategori')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold">Kelola Kategori</h2>
            <p class="mt-1 text-sm text-brand-darkGray">Tambahkan, ubah, atau nonaktifkan kategori produk Nike kamu.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="rounded-full bg-brand-black px-5 py-2 text-sm font-semibold text-brand-white transition hover:bg-brand-darkGray">Tambah Kategori</a>
    </div>

    <div class="rounded-2xl bg-brand-white shadow-sm shadow-black/5">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left text-sm">
                <thead>
                    <tr class="border-b border-brand-gray text-xs uppercase tracking-wide text-brand-darkGray">
                        <th class="px-6 py-4 font-semibold">Nama</th>
                        <th class="px-6 py-4 font-semibold">Slug</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Dibuat</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-gray/70">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-brand-gray/60">
                            <td class="px-6 py-4 font-medium">
                                <div>{{ $category->name }}</div>
                                @if ($category->description)
                                    <div class="text-xs text-brand-darkGray">{{ Str::limit($category->description, 80) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-darkGray">{{ $category->slug }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $category->is_active ? 'bg-brand-black text-brand-white' : 'bg-brand-gray text-brand-darkGray' }}">
                                    {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-darkGray">{{ $category->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="rounded-full border border-brand-black/10 px-4 py-1.5 text-xs font-semibold text-brand-black transition hover:bg-brand-gray">Edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-full border border-red-300 px-4 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-brand-darkGray">Belum ada kategori. Mulai dengan menambahkan kategori baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-brand-gray/70 px-6 py-4">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
