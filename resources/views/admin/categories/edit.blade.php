@extends('admin.layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <div class="max-w-3xl">
        <h2 class="text-2xl font-semibold">Edit Kategori</h2>
        <p class="mt-1 text-sm text-brand-darkGray">Perbarui informasi kategori: {{ $category->name }}</p>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-brand-black" for="name">Nama Kategori</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                    class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-brand-black" for="slug">Slug (opsional)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}"
                    class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20"
                    placeholder="contoh: nike-air-jordan" />
                <p class="mt-1 text-xs text-brand-darkGray">Jika dikosongkan akan otomatis dibuat dari nama.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-brand-black" for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                    class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20"
                    placeholder="Ceritakan tentang kategori ini">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                    class="h-4 w-4 rounded border-brand-black/20 text-brand-black focus:ring-brand-black" />
                <label for="is_active" class="text-sm font-medium">Kategori aktif</label>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.categories.index') }}" class="rounded-full border border-brand-black/10 px-5 py-2 text-sm font-semibold text-brand-darkGray transition hover:bg-brand-gray">Batal</a>
                <button type="submit" class="rounded-full bg-brand-black px-5 py-2 text-sm font-semibold text-brand-white transition hover:bg-brand-darkGray">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
