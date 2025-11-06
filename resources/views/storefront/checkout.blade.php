@extends('storefront.layouts.app')

@section('title', 'Checkout - Nstore')

@section('content')
    <section class="bg-brand-white py-16">
        <div class="mx-auto grid w-full max-w-6xl gap-10 px-6 lg:grid-cols-[2fr,1fr] lg:items-start">
            <div>
                <div class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.3em] text-brand-darkGray">
                    <span class="flex items-center gap-2">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full border border-brand-black text-xs text-brand-black">1</span>
                        Keranjang
                    </span>
                    <span class="h-px w-8 bg-brand-black/20"></span>
                    <span class="flex items-center gap-2 text-brand-black">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-black text-xs text-brand-white">2</span>
                        Checkout
                    </span>
                    <span class="h-px w-8 bg-brand-black/20"></span>
                    <span class="flex items-center gap-2 opacity-60">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full border border-brand-black text-xs">3</span>
                        Selesai
                    </span>
                </div>

                <h1 class="mt-6 text-3xl font-semibold">Checkout</h1>
                <p class="mt-2 text-sm text-brand-darkGray">Lengkapi detail pengiriman kamu untuk menyelesaikan pesanan.</p>

                <form action="{{ route('storefront.checkout.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-8">
                    @csrf

                    <div class="space-y-5 rounded-3xl border border-brand-black/10 bg-brand-white p-6 shadow-sm shadow-black/5">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="customer_name" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray">Nama Lengkap</label>
                                <input id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required class="mt-2 w-full rounded-full border {{ $errors->has('customer_name') ? 'border-red-500 focus:border-red-500 focus:ring-red-200' : 'border-brand-black/20 focus:border-brand-black focus:ring-brand-black/20' }} bg-brand-gray px-4 py-3 text-sm focus:outline-none focus:ring-2">
                                @error('customer_name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="customer_email" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray">Email</label>
                                <input id="customer_email" name="customer_email" type="email" value="{{ old('customer_email') }}" required class="mt-2 w-full rounded-full border {{ $errors->has('customer_email') ? 'border-red-500 focus:border-red-500 focus:ring-red-200' : 'border-brand-black/20 focus:border-brand-black focus:ring-brand-black/20' }} bg-brand-gray px-4 py-3 text-sm focus:outline-none focus:ring-2">
                                @error('customer_email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="customer_phone" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray">No. Telepon</label>
                                <input id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required class="mt-2 w-full rounded-full border {{ $errors->has('customer_phone') ? 'border-red-500 focus:border-red-500 focus:ring-red-200' : 'border-brand-black/20 focus:border-brand-black focus:ring-brand-black/20' }} bg-brand-gray px-4 py-3 text-sm focus:outline-none focus:ring-2">
                                @error('customer_phone')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="payment_method" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray">Metode Pembayaran</label>
                                <select id="payment_method" name="payment_method" required class="mt-2 w-full rounded-full border {{ $errors->has('payment_method') ? 'border-red-500 focus:border-red-500 focus:ring-red-200' : 'border-brand-black/20 focus:border-brand-black focus:ring-brand-black/20' }} bg-brand-gray px-4 py-3 text-sm focus:outline-none focus:ring-2">
                                    <option value="cod" {{ old('payment_method') === 'cod' ? 'selected' : '' }}>COD (Bayar di Tempat)</option>
                                    <option value="transfer" {{ old('payment_method') === 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                </select>
                                @error('payment_method')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror

                                <div id="payment-transfer-hint" class="{{ old('payment_method', 'cod') === 'transfer' ? 'mt-3 space-y-4 rounded-2xl bg-brand-gray/80 p-4 text-xs text-brand-darkGray' : 'hidden mt-3 space-y-4 rounded-2xl bg-brand-gray/80 p-4 text-xs text-brand-darkGray' }}">
                                    <div>
                                        <div class="font-semibold uppercase tracking-[0.25em] text-brand-black">Transfer Bank</div>
                                        <p class="mt-2 leading-relaxed">Silakan transfer ke BCA 123456789 a.n. Nstore. Upload bukti pembayaran agar pesanan bisa kami proses lebih cepat.</p>
                                    </div>

                                    <div class="rounded-2xl border border-brand-black/10 bg-brand-white p-4 text-xs text-brand-darkGray">
                                        <label for="payment_proof" class="text-[11px] font-semibold uppercase tracking-[0.3em] text-brand-darkGray">Upload Bukti Pembayaran</label>
                                        <input type="file" name="payment_proof" id="payment_proof" accept="image/jpeg,image/png,application/pdf" class="mt-2 w-full rounded-full border {{ $errors->has('payment_proof') ? 'border-red-500 focus:border-red-500 focus:ring-red-200' : 'border-brand-black/20 focus:border-brand-black focus:ring-brand-black/20' }} bg-brand-gray px-4 py-2 text-sm focus:outline-none focus:ring-2">
                                        <p class="mt-2 text-[11px] text-brand-darkGray/80">Format JPG, PNG, atau PDF maks. 4MB.</p>
                                        @error('payment_proof')
                                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="shipping_address" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray">Alamat Pengiriman</label>
                            <textarea id="shipping_address" name="shipping_address" rows="4" required class="mt-2 w-full rounded-3xl border {{ $errors->has('shipping_address') ? 'border-red-500 focus:border-red-500 focus:ring-red-200' : 'border-brand-black/20 focus:border-brand-black focus:ring-brand-black/20' }} bg-brand-gray px-4 py-3 text-sm focus:outline-none focus:ring-2">{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="notes" class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-darkGray">Catatan (Opsional)</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-2 w-full rounded-3xl border border-brand-black/20 bg-brand-gray px-4 py-3 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20" placeholder="Contoh: Tolong kirim sebelum jam 5 sore">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('storefront.cart.index') }}" class="flex w-full items-center justify-center rounded-full border border-brand-black px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-brand-black transition hover:bg-brand-black hover:text-brand-white sm:w-auto">Kembali ke Keranjang</a>
                        <button type="submit" class="w-full rounded-full bg-brand-black px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-brand-white transition hover:bg-brand-darkGray sm:w-auto">Buat Pesanan</button>
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl border border-brand-black/10 bg-brand-gray/60 p-4 text-xs text-brand-darkGray">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-black text-sm font-semibold text-brand-white">✓</span>
                        <div>
                            <div class="font-semibold uppercase tracking-[0.25em] text-brand-black">Pembayaran Aman</div>
                            <p class="mt-1 leading-relaxed">Data kamu diproteksi dan kami hanya memproses pesanan setelah konfirmasi pembayaran berhasil.</p>
                        </div>
                    </div>
                </form>
            </div>

            <aside class="space-y-5 lg:sticky lg:top-28">
                <div class="rounded-3xl border border-brand-black/10 bg-brand-white p-6 shadow-sm shadow-black/5">
                    <h2 class="text-lg font-semibold">Ringkasan Pesanan</h2>
                    <div class="mt-4 space-y-3 text-sm text-brand-darkGray">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-semibold text-brand-black">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkir</span>
                            <span class="font-semibold text-brand-black">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold text-brand-black">
                            <span>Total</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-brand-black/10 bg-brand-gray/60 p-6">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-darkGray">Ringkasan Barang</h3>
                    <div class="mt-4 space-y-4 text-sm">
                        @foreach ($items as $item)
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="font-semibold text-brand-black">{{ $item['product_name'] }}</div>
                                    <div class="text-xs text-brand-darkGray">Qty {{ $item['quantity'] }} @ {{ $item['size_label'] ?? 'Free Size' }}</div>
                                </div>
                                <div class="text-sm font-semibold text-brand-black">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-3 rounded-3xl border border-brand-black/10 bg-brand-white p-6 shadow-sm shadow-black/5 text-sm text-brand-darkGray">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-black">Info Pengiriman</h3>
                    <p>Pesanan diproses dalam 1×24 jam kerja. Estimasi tiba <span class="font-semibold text-brand-black">2-4 hari</span> untuk Jabodetabek dan <span class="font-semibold text-brand-black">4-6 hari</span> untuk luar kota.</p>
                    <p class="rounded-2xl bg-brand-gray/70 p-3 text-xs">Kami kirimkan nomor resi via email/WhatsApp segera setelah paket dikirim.</p>
                </div>
            </aside>
        </div>
    </section>

    <script>
        const paymentSelect = document.getElementById('payment_method');
        const transferHint = document.getElementById('payment-transfer-hint');
        const paymentProofInput = document.getElementById('payment_proof');

        if (paymentSelect && transferHint) {
            const toggleHint = () => {
                if (paymentSelect.value === 'transfer') {
                    transferHint.classList.remove('hidden');
                    if (paymentProofInput) {
                        paymentProofInput.required = true;
                    }
                } else {
                    transferHint.classList.add('hidden');
                    if (paymentProofInput) {
                        paymentProofInput.required = false;
                        paymentProofInput.value = '';
                    }
                }
            };

            paymentSelect.addEventListener('change', toggleHint);
            toggleHint();
        }
    </script>
@endsection
