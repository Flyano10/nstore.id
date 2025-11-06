@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $isEdit = isset($product);
    $existingImages = $isEdit ? $product->images->sortBy('sort_order') : collect();
    $sizeValue = old('sizes_data');

    if ($sizeValue === null && $isEdit) {
        $sizeValue = $product->sizes
            ->map(function ($size) {
                $parts = [$size->size, $size->stock];

                if (! is_null($size->price)) {
                    $parts[] = $size->price;
                }

                return implode(' | ', $parts);
            })
            ->implode("\n");
    }

    $removeSelections = collect(old('remove_images', []))->map(fn ($id) => (int) $id)->all();
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <div class="space-y-6">
        <div>
            <label class="block text-sm font-semibold text-brand-black" for="name">Nama Produk</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required
                class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-brand-black" for="category_id">Kategori</label>
            <select id="category_id" name="category_id" required
                class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20">
                <option value="" disabled {{ old('category_id', $product->category_id ?? '') ? '' : 'selected' }}>Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (string) old('category_id', $product->category_id ?? '') === (string) $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-brand-black" for="slug">Slug (opsional)</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug ?? '') }}"
                class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20"
                placeholder="contoh: nike-air-jordan-1-high" />
            <p class="mt-1 text-xs text-brand-darkGray">Jika dikosongkan akan otomatis dibuat dari nama.</p>
        </div>

        <div>
            <label class="block text-sm font-semibold text-brand-black" for="sku">SKU</label>
            <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku ?? '') }}" required
                class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-brand-black" for="price">Harga (Rp)</label>
            <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" required
                class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-brand-black" for="compare_at_price">Harga Coret (opsional)</label>
            <input type="number" step="0.01" id="compare_at_price" name="compare_at_price" value="{{ old('compare_at_price', $product->compare_at_price ?? '') }}"
                class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20" />
        </div>

        <div class="flex items-center gap-3">
            <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}
                class="h-4 w-4 rounded border-brand-black/20 text-brand-black focus:ring-brand-black" />
            <label for="is_active" class="text-sm font-medium">Produk aktif</label>
        </div>
    </div>

    <div class="space-y-6">
        <div>
            <label class="block text-sm font-semibold text-brand-black" for="short_description">Deskripsi Singkat</label>
            <textarea id="short_description" name="short_description" rows="3"
                class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20"
                placeholder="Highlight produk singkat">{{ old('short_description', $product->short_description ?? '') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-semibold text-brand-black" for="description">Deskripsi Lengkap</label>
            <textarea id="description" name="description" rows="6"
                class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20"
                placeholder="Detail produk, material, fitur">{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        @if ($isEdit && $existingImages->isNotEmpty())
            <div>
                <p class="text-sm font-semibold text-brand-black">Gambar saat ini</p>
                <div class="mt-3 space-y-3">
                    @foreach ($existingImages as $image)
                        @php
                            $imageUrl = Str::startsWith($image->path, ['http://', 'https://'])
                                ? $image->path
                                : Storage::url($image->path);
                            $label = $loop->iteration === 1 ? 'Gambar Utama' : 'Gambar #' . $loop->iteration;
                        @endphp
                        <div class="flex items-center gap-4 rounded-xl border border-brand-black/10 bg-brand-gray/20 p-3">
                            <input type="hidden" name="existing_images[]" value="{{ $image->id }}">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name ?? 'Produk' }}" class="h-16 w-16 rounded-lg object-cover" />
                            <div class="flex-1 text-xs text-brand-darkGray">
                                <p class="font-semibold text-brand-black">{{ $label }}</p>
                                @if (! Str::startsWith($image->path, ['http://', 'https://']))
                                    <p class="mt-1 truncate">{{ $image->path }}</p>
                                @endif
                            </div>
                            <label class="flex items-center gap-2 text-xs font-semibold text-brand-darkGray">
                                <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" {{ in_array($image->id, $removeSelections, true) ? 'checked' : '' }} />
                                <span>Hapus</span>
                            </label>
                        </div>
                    @endforeach
                </div>
                <p class="mt-2 text-xs text-brand-darkGray">Centang gambar yang ingin dihapus. Urutan mengikuti tampilan saat ini.</p>
            </div>
        @endif

        <div>
            <label class="block text-sm font-semibold text-brand-black" for="image_files">Unggah Gambar Produk</label>
            <input id="image_files" name="image_files[]" type="file" accept="image/jpeg,image/png,image/webp" multiple
                class="mt-2 block w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm file:mr-4 file:rounded-full file:border-0 file:bg-brand-black file:px-4 file:py-2 file:text-sm file:font-semibold file:text-brand-white hover:file:bg-brand-darkGray focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20" />
            <p class="mt-1 text-xs text-brand-darkGray">Upload minimal satu gambar (JPG, PNG, atau WebP, maksimal 4MB per file). Urutan upload menentukan urutan tampilan, gambar pertama akan jadi utama.</p>
        </div>

        <div>
            <label class="block text-sm font-semibold text-brand-black" for="sizes_data">Ukuran &amp; Stok</label>
            <textarea id="sizes_data" name="sizes_data" rows="6"
                class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2.5 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20"
                placeholder="41 | 5
42 | 8 | 2100000">{{ $sizeValue }}</textarea>
            <p class="mt-1 text-xs text-brand-darkGray">Format: ukuran | stok | harga_opsional. Pisahkan dengan garis vertikal.
                Contoh: <span class="font-semibold">41 | 5 | 2100000</span>.</p>
        </div>
    </div>
</div>
