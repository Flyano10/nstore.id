@component('mail::message')
# Terima kasih, {{ $order->customer_name }}!

Pesanan kamu dengan nomor **{{ $order->order_number }}** sudah kami terima pada {{ $order->created_at->format('d M Y H:i') }}.

@component('mail::panel')
**Metode Pembayaran:** {{ strtoupper($order->payment_method) }}  
**Status Pembayaran:** {{ ucwords(str_replace('_', ' ', $order->payment_status)) }}  
**Total:** Rp {{ number_format($order->total, 0, ',', '.') }}
@endcomponent

## Rincian Produk
@component('mail::table')
| Produk | Qty | Harga |
| :----- | :-: | ----: |
@foreach ($order->items as $item)
| {{ $item->product_name }} ({{ $item->product_size ?? 'Free Size' }}) | {{ $item->quantity }} | Rp {{ number_format($item->total, 0, ',', '.') }} |
@endforeach
@endcomponent

Jika memilih transfer, jangan lupa kirim bukti pembayaran agar kami bisa memproses lebih cepat.

Terima kasih sudah belanja di **Nstore**!

Salam,
Tim Nstore
@endcomponent
