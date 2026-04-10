# 📦 LOGITRACK

**Sistem Logistik Terpadu LogiTrack** adalah aplikasi manajemen pengiriman barang dan logistik modern berbasis web. Dibangun menggunakan framework Laravel, LogiTrack menyediakan solusi komprehensif untuk mengelola pesanan pengiriman, pencetakan resi (AWB), pelacakan paket, serta manajemen kurir dan pengguna.

## ✨ Fitur Utama

- **Manajemen Order (Pengiriman):** Buat pesanan dengan perhitungan tarif otomatis berdasarkan berat (aktual/volumetrik) dan koli.
- **Master Data Wilayah Terlengkap:** Mendukung data wilayah seluruh Indonesia (38 Provinsi, 514 Kota/Kabupaten, 7.277 Kecamatan, dan 83.762 Kelurahan/Desa) yang terintegrasi di sistem untuk kelengkapan alamat pengirim dan penerima.
- **Cetak Resi & QR Code:** Mencetak label resi (AWB) pengiriman yang responsif dan siap cetak dengan QR Code generator terintegrasi.
- **Pelacakan (Tracking) Paket:** Pembaruan status pengiriman secara real-time (Pending, In Transit, Delivered, dll) dengan lini masa (timeline) yang interaktif dan bukti foto (Proof of Delivery / POD).
- **Dashboard Admin Modern:** Interface pengguna (UI) yang bersih, elegan, dan profesional (mengadopsi styling *Tailwind CSS*) dengan arsitektur sidebar yang dinamis.
- **Role & Akses (Master User & Kurir App):** Mendukung manajemen pengguna yang terpisah sesuai wewenang.

## 🛠️ Stack Teknologi

- **Backend:** Laravel 11.x (PHP 8.2+)
- **Database:** MySQL
- **Frontend / Styling:** Blade Templating, Tailwind CSS, Alpine.js
- **Ekstensi & Pustaka:** qrcode-generator, SweetAlert2

## 🚀 Panduan Instalasi (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan LogiTrack di mesin lokal Anda:

### 1. Persyaratan Sistem
Pastikan Anda sudah menginstal:
- PHP >= 8.2
- Composer
- MySQL / MariaDB Server
- Node.js & NPM
- Git

### 2. Kloning Repository & Instalasi Dependensi
```bash
git clone https://github.com/AchmadLutfi196/logitrack.git
cd logitrack

# Install PHP dependencies
composer install

# Install Frontend dependencies & build asset
npm install
npm run build
```

### 3. Konfigurasi Environment (Lingkungan)
Salin `.env.example` ke `.env` lalu sesuaikan konfigurasi database.
```bash
cp .env.example .env
```
Buka file `.env` dan pastikan konfigurasi driver database diatur ke MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=logitrack
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Application Key & Storage
```bash
php artisan key:generate
php artisan storage:link
```

### 5. Migrasi & Seeding Database
**Penting:** Proses seeding awal akan memasukkan >83.000 data wilayah ke dalam tabel MySQL. Pastikan konfigurasi database sudah benar.
```bash
php artisan migrate --force
php artisan db:seed --class=LocationSeeder --force
```
*(Catatan: LocationSeeder akan mengimpor data seluruh provinsi, kota, dan wilayah Indonesia dari file CSV lokal ke dalam database menggunakan sistem batch-insert).*

### 6. Jalankan Server
Jalankan server aplikasi secara lokal:
```bash
php artisan serve
```
Akses aplikasi melalui browser di: `http://localhost:8000`

## 📸 Tampilan Sistem

- **Order Detail & AWB Print:** Tampilan detail pengiriman terstruktur dengan label cetak termal (*Thermal Ready*) yang berisi QR code, rincian biaya, dan info pengirim/penerima.
- **Sistem Notifikasi:** Dilengkapi Alert interaktif menggunakan *SweetAlert2*.

---

🚀 *Dibangun untuk kemudahan operasional pengiriman ekspres dan logistik.*
