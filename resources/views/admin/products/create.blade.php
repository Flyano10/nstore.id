@extends('admin.layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold">Tambah Produk</h2>
            <p class="mt-1 text-sm text-brand-darkGray">Lengkapi detail produk Nike terbaru kamu.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="rounded-full border border-brand-black/10 px-5 py-2 text-sm font-semibold text-brand-darkGray transition hover:bg-brand-gray">Kembali</a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-8">
        @csrf

        @include('admin.products._form', ['categories' => $categories])

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-full bg-brand-black px-5 py-2 text-sm font-semibold text-brand-white transition hover:bg-brand-darkGray">Simpan Produk</button>
        </div>
    </form>
@endsection
