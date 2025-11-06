@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold">Pesanan {{ $order->order_number }}</h2>
            <p class="mt-1 text-sm text-brand-darkGray">Dibuat pada {{ $order->created_at->format('d M Y H:i') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="rounded-full border border-brand-black/10 px-5 py-2 text-sm font-semibold text-brand-darkGray transition hover:bg-brand-gray">Kembali</a>
    </div>

    <section class="mt-6 grid gap-6 lg:grid-cols-3">
        <article class="rounded-2xl bg-brand-white p-6 shadow-sm shadow-black/5 lg:col-span-2">
            <h3 class="text-lg font-semibold">Informasi Customer</h3>
            <dl class="mt-4 grid gap-4 md:grid-cols-2">
                <div>
                    <dt class="text-xs uppercase tracking-wide text-brand-darkGray">Nama</dt>
                    <dd class="text-sm font-semibold text-brand-black">{{ $order->customer_name }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-brand-darkGray">Email</dt>
                    <dd class="text-sm text-brand-black">{{ $order->customer_email }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-brand-darkGray">Telepon</dt>
                    <dd class="text-sm text-brand-black">{{ $order->customer_phone }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-brand-darkGray">User</dt>
                    <dd class="text-sm text-brand-black">{{ $order->user?->name ?? 'Guest checkout' }}</dd>
                </div>
            </dl>

            <div class="mt-6">
                <dt class="text-xs uppercase tracking-wide text-brand-darkGray">Alamat Pengiriman</dt>
                <dd class="mt-2 rounded-xl border border-brand-black/10 bg-brand-gray px-4 py-3 text-sm leading-relaxed">{{ $order->shipping_address }}</dd>
            </div>

            @if ($order->notes)
                <div class="mt-6">
                    <dt class="text-xs uppercase tracking-wide text-brand-darkGray">Catatan Customer</dt>
                    <dd class="mt-2 rounded-xl border border-brand-black/10 bg-brand-gray px-4 py-3 text-sm leading-relaxed">{{ $order->notes }}</dd>
                </div>
            @endif
        </article>

        <article class="rounded-2xl bg-brand-white p-6 shadow-sm shadow-black/5">
            <h3 class="text-lg font-semibold">Status Pesanan</h3>

            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs uppercase tracking-wide text-brand-darkGray" for="status">Status</label>
                    <select id="status" name="status" class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20">
                        @foreach ($statusOptions as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wide text-brand-darkGray" for="payment_status">Status Pembayaran</label>
                    <select id="payment_status" name="payment_status" class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20">
                        @foreach ($paymentStatusOptions as $paymentStatus)
                            <option value="{{ $paymentStatus }}" {{ $order->payment_status === $paymentStatus ? 'selected' : '' }}>{{ ucfirst($paymentStatus) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wide text-brand-darkGray" for="notes">Catatan Internal</label>
                    <textarea id="notes" name="notes" rows="4" class="mt-2 w-full rounded-xl border border-brand-black/10 bg-brand-white px-4 py-2 text-sm focus:border-brand-black focus:outline-none focus:ring-2 focus:ring-brand-black/20" placeholder="Catatan admin (opsional)">{{ old('notes', $order->notes) }}</textarea>
                    <p class="mt-1 text-xs text-brand-darkGray">Catatan ini bisa diupdate untuk keperluan internal.</p>
                </div>

                <button type="submit" class="w-full rounded-full bg-brand-black px-4 py-2 text-sm font-semibold text-brand-white transition hover:bg-brand-darkGray">Update Status</button>
            </form>

            <div class="mt-4 flex flex-col gap-3">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="contents">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ $order->status }}">
                    <input type="hidden" name="payment_status" value="paid">
                    <input type="hidden" name="notes" value="{{ $order->notes ?? '' }}">
                    <button type="submit" class="w-full rounded-full border border-brand-black px-4 py-2 text-sm font-semibold uppercase tracking-[0.25em] text-brand-black transition hover:bg-brand-black hover:text-brand-white">Tandai Sudah Dibayar</button>
                </form>

                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="contents">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="processing">
                    <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">
                    <input type="hidden" name="notes" value="{{ $order->notes ?? '' }}">
                    <button type="submit" class="w-full rounded-full border border-brand-black px-4 py-2 text-sm font-semibold uppercase tracking-[0.25em] text-brand-black transition hover:bg-brand-black hover:text-brand-white">Set ke Processing</button>
                </form>
            </div>

            <div class="mt-6 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-brand-darkGray">Subtotal</span>
                    <span class="font-semibold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-brand-darkGray">Ongkir</span>
                    <span class="font-semibold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-semibold">
                    <span>Total</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>

            @if ($order->payment_method === 'transfer')
                <div class="mt-6 space-y-3 rounded-2xl border border-brand-black/10 bg-brand-gray/60 p-4 text-sm text-brand-darkGray">
                    <div class="text-xs uppercase tracking-wide text-brand-darkGray">Bukti Pembayaran</div>
                    <p>Metode transfer bank. Pastikan bukti sudah sesuai sebelum mengubah status ke <span class="font-semibold text-brand-black">paid</span>.</p>

                    @if ($order->payment_proof_path)
                        <div class="rounded-xl border border-brand-black/10 bg-brand-white p-4">
                            <div class="flex items-center justify-between text-xs uppercase tracking-wide text-brand-darkGray">
                                <span>File Bukti</span>
                                <span>{{ strtoupper(pathinfo($order->payment_proof_path, PATHINFO_EXTENSION)) }}</span>
                            </div>
                            <a href="{{ route('admin.orders.payment-proof', $order) }}" class="mt-3 inline-flex items-center gap-2 rounded-full border border-brand-black px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-black transition hover:bg-brand-black hover:text-brand-white">Lihat / Unduh</a>
                        </div>
                    @else
                        <div class="rounded-xl border border-dashed border-brand-darkGray/30 bg-brand-white/70 p-4 text-xs text-brand-darkGray">Belum ada bukti yang diunggah pelanggan.</div>
                    @endif
                </div>
            @endif
        </article>
    </section>

    <section class="mt-8 rounded-2xl bg-brand-white p-6 shadow-sm shadow-black/5">
        <h3 class="text-lg font-semibold">Item Pesanan</h3>

        <div class="mt-4 overflow-x-auto">
            <table class="w-full min-w-[720px] text-left text-sm">
                <thead>
                    <tr class="border-b border-brand-gray text-xs uppercase tracking-wide text-brand-darkGray">
                        <th class="px-4 py-3 font-semibold">Produk</th>
                        <th class="px-4 py-3 font-semibold">SKU</th>
                        <th class="px-4 py-3 font-semibold">Ukuran</th>
                        <th class="px-4 py-3 font-semibold">Qty</th>
                        <th class="px-4 py-3 font-semibold">Harga</th>
                        <th class="px-4 py-3 font-semibold">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-gray/70">
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $item->product_name }}</td>
                            <td class="px-4 py-3 text-sm text-brand-darkGray">{{ $item->product_sku }}</td>
                            <td class="px-4 py-3 text-sm text-brand-darkGray">{{ $item->product_size ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 font-semibold">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
