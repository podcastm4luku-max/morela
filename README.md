# 🌴 MORELA TOURISM - LARAVEL BLADE PROJECT

**“Jelajah Pesona Morela – Alam, Budaya & Masyarakat”**
*Portal Digital Pariwisata Desa Morela, Kec. Leihitu, Kab. Maluku Tengah*
*Kolaborasi Program Pengabdian Mahasiswa Universitas Darussalam Ambon*

---

## 🚀 Panduan Instalasi & Menjalankan Project Laravel

### Persyaratan Sistem:
- PHP >= 8.2
- Composer >= 2.0
- MySQL / MariaDB (XAMPP / Laragon)
- Node.js & NPM (untuk kompilasi Tailwind CSS)

### Langkah-Langkah:

1. **Clone atau Copy folder `laravel` ke web server lokal (htdocs / www)**:
   ```bash
   cd laravel
   ```

2. **Install Dependensi Composer**:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment `.env`**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Sesuaikan pengaturan database di file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=morela_tourism
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Jalankan Migrasi Database & Seeder**:
   ```bash
   php artisan migrate --seed
   ```

5. **Install & Kompilasi Asset Tailwind CSS (Opsional bila menggunakan Vite)**:
   ```bash
   npm install
   npm run build
   ```

6. **Jalankan Server Lokal Laravel**:
   ```bash
   php artisan serve
   ```
   Buka browser di: `http://127.0.0.1:8000`

---

## 📁 Struktur Berkas Laravel Blade yang Disediakan

- `routes/web.php` : Rute publik, rute E-Tiket QRIS, dan rute Admin Dashboard
- `app/Models/` :
  - `Destination.php` : Model destinasi wisata lengkap dengan relasi ke tiket
  - `TicketBooking.php` : Model pemesanan tiket, QR validator, dan status pembayaran
  - `Umkm.php`, `Culture.php`, `News.php`, `Event.php`
- `app/Http/Controllers/` :
  - `TicketController.php` : Logika pemesanan tiket, kalkulasi biaya, integrasi QRIS, dan cetak e-tiket
  - `DestinationController.php` : Katalog wisata dan kode QR
  - `AdminController.php` : Statistik pendapatan tiket dan scanner validasi check-in loket
- `database/migrations/` :
  - `create_destinations_table.php`
  - `create_ticket_bookings_table.php`
  - `2026_10_05_000003_create_social_media_table.php` (Tabel Media Sosial Desa)
- `resources/views/` :
  - `layouts/app.blade.php` : Layout utama dengan navbar responsif berisi menu **Tiket Wisata**
  - `layouts/admin.blade.php` : Layout Dashboard Admin dengan navigasi sidebar menu **Media Sosial**
  - `admin/social_media/index.blade.php` : Daftar kelola media sosial & toggle status
  - `admin/social_media/create.blade.php` : Form tambah akun media sosial dengan preset
  - `admin/social_media/edit.blade.php` : Form ubah akun media sosial
  - `tickets/booking.blade.php` : Form pemesanan tiket & kalkulasi retribusi desa
  - `tickets/payment.blade.php` : Tampilan simulasi QRIS & pembayaran
  - `tickets/show.blade.php` : E-Tiket resmi boarding-pass (printable)
  - `admin/dashboard.blade.php` : Dashboard admin desa
  - `admin/tickets.blade.php` : Validasi check-in loket & log transaksi

---

## ⚡ Perintah Migrasi Khusus Media Sosial (Aman Tanpa Reset Data Existing):
Untuk menambahkan fitur Media Sosial ke server hosting/database yang sudah berjalan tanpa mereset data:
```bash
php artisan migrate --path=/database/migrations/2026_10_05_000003_create_social_media_table.php
php artisan db:seed --class=SocialMediaSeeder
```
