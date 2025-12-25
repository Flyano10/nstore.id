<div align="center">

![Nstore Logo](resources/images/nike-footer.png)

# Nstore Storefront

Landing page buat jualan sneakers Nike. Simpel tapi tetep keliatan modern.

</div>

## Apa ini

Bikin storefront sederhana buat showcase koleksi sneakers. Fiturnya ga ribet - hero yang dinamis, list produk langsung dari database, plus beberapa animasi kecil biar ga boring aja.

## Yang ada di dalemnya

**Hero Section**
- Nampil produk paling baru otomatis dengan badge "New Release"
- Auto rotate tiap 6 detik
- CTA langsung ke detail produk

**Highlight & Koleksi**
- 3 produk pilihan minggu ini
- Slider horizontal buat koleksi terbaru (ada tombol prev/next)
- Section best seller

**UI Stuff**
- Navbar responsive, mobile menu pake panel blur (bisa tutup pake ESC)
- Footer hitam dengan swoosh, social links, sama form newsletter
- AOS animation pas scroll

**Admin Panel**
- Upload gambar produk langsung
- Atur urutan produk
- Preview sebelum publish

## Tech

- Laravel 10
- Blade + Tailwind
- Vite
- Alpine/Vanilla JS buat slider
- MySQL

## Requirement

- PHP 8.2 ke atas
- Composer
- Node.js 18+ & npm
- MySQL/MariaDB

## Setup

```bash
# Clone
git clone https://github.com/<username>/nstore.git
cd nstore

# Install
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database (edit .env dulu)
php artisan migrate

# Storage link buat gambar
php artisan storage:link

# Run
npm run dev
# tab lain:
php artisan serve
```

Buka `http://127.0.0.1:8000` dan login ke admin buat mulai masukin produk.

## Folder Penting

```
app/Http/Controllers/Storefront/HomeController.php  → query data landing
resources/views/storefront/home.blade.php           → halaman utama
resources/views/storefront/layouts/app.blade.php    → header, footer, script
resources/css/app.css                               → custom utility
resources/views/admin/products/_form.blade.php      → form upload produk
```

## Demo Flow

1. Landing page → hero dinamis + badge new release
2. Scroll ke highlight → liat badge status
3. Geser slider pake tombol samping "View All"
4. Buka nav mobile (responsive mode)
5. Footer + newsletter CTA

## To-do Kedepan

- Login sosial biar checkout lebih cepet
- Payment gateway (midtrans atau sejenisnya)
- Dashboard stok realtime

Mau kontribusi? Fork aja terus bikin PR. Prefer kode yang rapi dan konsisten sama Tailwind custom yang udah ada.

---

Ada saran atau ide? Langsung aja bikin issue atau DM!