<div align="center">

![Nstore Logo](resources/images/nike-footer.png)

# Nstore Storefront

_Single page storefront sederhana yang saya bangun untuk showcase koleksi sneakers Nike dengan sentuhan modern._

</div>

## Ringkasan Proyek

Saya membuat proyek ini untuk mendemokan pengalaman landing page e-commerce yang rapih namun tetap gampang di-maintain. Fokus utama ada di hero dinamis, list produk yang langsung narik data dari database, dan interaksi kecil-kecilan (scroll animation, slider, dsb) supaya presentasinya enak ditonton.

## Fitur Unggulan

- **Hero Section Dinamis** – otomatis menampilkan produk paling baru dengan badge “New Release”, CTA langsung ke detail, plus rotasi fade setiap 6 detik.
- **Highlight Minggu Ini** – 3 produk terkurasi dengan deskripsi singkat dan tombol detail.
- **Koleksi Terbaru** – slider horizontal dengan tombol navigasi berada di samping “View All”.
- **Best Seller & About Section** – menampilkan USP brand dan alasan kenapa harus belanja di Nstore.
- **Footer baru** – nuansa hitam dengan swoosh, social links, kontak support, dan form newsletter.
- **Navbar responsif** – tombol “Menu” khusus mobile dengan panel blur yang bisa ditutup lewat ESC/responsive resize.
- **Admin Upload** – di dashboard admin saya sudah ubah supaya gambar produk bisa diupload langsung, urutan bisa diatur, dan ada preview.
- **AOS Animation** – satu kali setup, semua section yang saya tandai animasi saat discroll (dan bisa muncul lagi kalau discroll balik).

## Stack yang Dipakai

- Laravel 10
- Blade + Tailwind (utility custom di `resources/css/app.css`)
- Vite untuk asset bundling
- Alpine/Vanilla JS ringan untuk slider & header
- MySQL (atau database lain yang kompatibel dengan Laravel)

## Prasyarat

Pastikan mesin sudah punya:

- PHP >= 8.2
- Composer
- Node.js >= 18 + npm
- MySQL/MariaDB
- Git

## Cara Menjalankan Lokal

```bash
# 1. Clone repo
git clone https://github.com/<username>/nstore.git
cd nstore

# 2. Pasang dependency backend
composer install

# 3. Copy env & generate key
cp .env.example .env
php artisan key:generate

# 4. Isi konfigurasi database di .env, lalu migrate (optional seed kalau mau)
php artisan migrate

# 5. Link storage supaya gambar produk kebaca publik
php artisan storage:link

# 6. Pasang dependency frontend
npm install

# 7. Jalanin build/dev server
npm run dev    # untuk proses development
# pada tab lain
php artisan serve
```

Setelah itu buka `http://127.0.0.1:8000` dan login ke admin (kalau belum ada user, bisa register manual dari form Auth) untuk mulai input produk.

## Struktur Folder Penting

- `app/Http/Controllers/Storefront/HomeController.php` – query data untuk landing page.
- `resources/views/storefront/home.blade.php` – layout halaman utama.
- `resources/views/storefront/layouts/app.blade.php` – header, footer, dan script global.
- `resources/css/app.css` – utility kustom untuk header, footer, slider, dsb.
- `resources/views/admin/products/_form.blade.php` – form upload gambar produk.

## Flow Demo (Quick Notes)

1. Buka landing page: highlight hero dinamis + badge.
2. Scroll ke highlight panel → jelaskan setiap badge status.
3. Geser slider “Koleksi Terbaru” pakai tombol di samping “View All”.
4. Tunjukkan nav mobile (DevTools → responsive → tekan “Menu”).
5. Tutup dengan footer baru + CTA newsletter.

## Pengembangan Lanjut

Hal-hal yang sedang saya pikirkan selanjutnya:

- Tambah login sosial/SSO biar checkout lebih cepat.
- Integrasi midtrans / payment gateway langsung dari checkout.
- Sistem stok realtime di admin (chart restock, dsb).

Kalau mau ikut kontribusi, feel free buat fork dan kirim PR. Saya tetep prefer gaya kode yang rapi dan tetap inline sama utility Tailwind custom.

–––

Terima kasih sudah mampir ke repo ini. Boleh banget kirim masukan lewat issue atau langsung DM kalau punya ide baru! 💯
