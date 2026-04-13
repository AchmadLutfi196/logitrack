# Hasil Testing LogiTrack

Aplikasi LogiTrack telah dilengkapi dengan **Automated Feature Testing** menggunakan Laravel Testing Framework (PHPUnit). Semua fitur utama telah diproteksi dengan pengujian untuk memastikan aplikasi berjalan dengan stabil sebelum dideploy.

## Ringkasan Eksekusi
- **Total Tests**: 27
- **Total Assertions**: 56
- **Status**: ✅ **PASSED** (Semua berhasil)
- **Durasi Eksekusi**: ~1.35s

---

## Detail Pengujian per Fitur

### 1. `AuthTest` (Otentikasi & Keamanan) ✅
Fitur ini memastikan sistem login dan logout berjalan dengan aman.
- `✓` login screen can be rendered
- `✓` users can authenticate using the login screen
- `✓` users can not authenticate with invalid password
- `✓` users can logout

### 2. `CourierTest` (Fitur Kurir & Tracking Updates) ✅
Menguji flow operasional dari sisi Kurir, termasuk update POD (Proof of Delivery).
- `✓` admin can view courier index
- `✓` admin can update tracking log
- `✓` admin can upload pod (Foto Penerima dan Update Status ke Delivered)

### 3. `LocationTest` (API Wilayah & Dropdown Cascading) ✅
Memastikan API yang memberikan data geografi merespon dengan benar.
- `✓` can get cities by province
- `✓` can get districts by city
- `✓` can get villages by district

### 4. `OrderTest` (Pembuatan Resi & Pengiriman) ✅
Skenario penting saat Admin pusat mendaftarkan resi baru dan kalkulasi volumenya.
- `✓` admin can view create order page
- `✓` guest cannot view create order page (Proteksi Otentikasi)
- `✓` admin can create order
- `✓` admin can view order details

### 5. `PublicTest` (Halaman Publik & Cek Resi) ✅
Menguji interface publik untuk customer atau pengirim saat melakukan pencarian.
- `✓` landing page can be rendered
- `✓` can track order with valid resi
- `✓` cannot track order with invalid resi (Error Handling)

### 6. `TrackingTest` (Admin Tracking Manajemen) ✅
Memastikan fitur pelacakan admin bekerja saat resi dimasukan.
- `✓` admin can view tracking index
- `✓` admin can search tracking by resi
- `✓` admin cannot search invalid resi
- `✓` admin can view tracking details

### 7. `UserTest` (CRUD Manajemen User) ✅
Mengamankan kapabilitas Super Admin atau user controller.
- `✓` admin can view users index
- `✓` admin can create user
- `✓` admin can update user
- `✓` admin can delete user

### 8. `ExampleTest` (Bawaan Laravel) ✅
- `✓` that true is true (Unit)
- `✓` the application returns a successful response (Feature)

---

## 🐛 Bug yang Ditemukan & Perbaikannya

Selama proses pembuatan dan eksekusi kerangka pengujian (testing), ditemukan beberapa bug internal / *logic clash* yang langsung diperbaiki agar aplikasi berjalan lebih sempurna dan konsisten:

1. **Missing `HasFactory` Trait pada Model Database** 
   - **Masalah:** Model `Order` dan `TrackingLog` sebelumnya belum menginisiasi *trait* standar Laravel (`HasFactory`), sehingga pembuatan data otomatis tak dapat dilakukan. Hal ini dapat menimbulkan kendala jika aplikasi kedepannya menggunakan system Seeders.
   - **Perbaikan:** Menambahkan `use Illuminate\Database\Eloquent\Factories\HasFactory;` dan trait `use HasFactory;` di dalam kedua Model tersebut.

2. **Parameter Meleset pada API Wilayah (Location)**
   - **Masalah:** Parameter argumen dalam route `web.php` untuk _dropdown_ wilayah mengharapkan entri ID referensi. Jika nama wilayah dipassing (seperti kota "Bandung"), query akan menghasilkan collection kosong (Empty JSON) yang bisa memecahkan dropdown UI.
   - **Perbaikan:** Menyelaraskan rute dinamis (API) Controller untuk menangkap struktur hirarki via `id` dengan akurat (`$province->id`, `$city->id`, `$district->id`).

3. **Validasi Password Tidak Lengkap**
   - **Masalah:** Controller untuk membuat User Baru (`UserController::store`) menetapkan aturan validasi ketat `password' => 'required|confirmed`. Input pengujian dan Form jika tidak menyediakan field `password_confirmation` akan gagal secara diam-diam (*silent failure*).
   - **Perbaikan:** Payload untuk menambahkan User/Admin baru dipastikan harus menangkap dan memvalidasi password menggunakan form confirmation.

4. **Struktur Relasi Foto POD (Proof of Delivery)**
   - **Masalah:** Saat Kurir mengunggah POD, logika awal beramsumsi foto bukti disimpan dalam kolom `pod_photo` pada Model `Order` secara terpusat. Namun *logic* pada Controller ternyata menggunakan skema yang lebih baik, yaitu menyimpan gambarnya langsung ke baris log pelacakan terbaru (`TrackingLog` record). Akibatnya tes pengecekan foto semulanya keliru. 
   - **Perbaikan:** Menyelaraskan business-logic Controller agar sistem pengecekan file berfokus pada Upload gambar di relasi `TrackingLog` serta memvalidasi peng-copy-an otomatis dari penerima asli ke kolom `pod_receiver_name` jika status paket berubah menjadi 'Delivered'.

---

> **Catatan**: Tes ini mensimulasikan browser requests dan berinteraksi dengan database SQLite in-memory, sehingga berjalan dengan sangat cepat dan tidak mengganggu data asli yang ada di sistem Anda.

*Dokumentasi digenerate secara otomatis berdasarkan hasil `php artisan test`.*
