# Fitur Yang Sudah Ada di Project LogiTrack

Dokumen ini merangkum fitur yang saat ini sudah terimplementasi berdasarkan route, controller, model, view, migration, dan seeder di project.

## 1. Fitur Public (User)

- Landing page pelacakan resi.
- Pelacakan paket berdasarkan nomor resi.
- Menampilkan progress status pengiriman dalam bentuk timeline.
- Menampilkan detail log tracking (tanggal, waktu, lokasi, deskripsi).
- Menampilkan foto bukti tracking (jika ada).
- Preview foto tracking dengan overlay card + tombol silang (X).
- Endpoint pelacakan mendukung request normal dan AJAX.

## 2. Fitur Auth

- Login admin dengan email + password.
- Opsi remember me saat login.
- Redirect otomatis ke halaman admin jika user sudah login.
- Logout dengan invalidate session + regenerate CSRF token.

## 3. Fitur Admin - Manajemen Order

- Form pembuatan order pengiriman.
- Validasi lengkap data pengirim, penerima, alamat, dan detail kiriman.
- Pembuatan nomor resi otomatis (format prefix JP + angka acak unik).
- Perhitungan berat volumetrik: (P x L x T) / 4000 x koli.
- Penentuan chargeable weight: nilai maksimum antara berat aktual dan berat volumetrik.
- Perhitungan total ongkir otomatis berdasarkan rumus: chargeable weight x harga per kg.
- Jika berat volumetrik lebih besar dari berat aktual, maka ongkir mengikuti berat volumetrik.
- Jika berat aktual lebih besar, maka ongkir mengikuti berat aktual.
- Contoh: berat aktual 2,5 kg, berat volumetrik 3 kg, harga per kg Rp10.000, maka ongkir = 3 x 10.000 = Rp30.000.
- Penentuan status awal order: Pending.
- Penentuan status pembayaran awal:
  - Cash -> Lunas
  - Tagihan -> Tagihan
- Auto-generate tracking log pertama saat order dibuat (status Pending).
- Halaman detail order dengan ringkasan pengirim, penerima, biaya, dan timeline tracking.

## 4. Fitur Admin - Cetak Resi (AWB)

- Tampilan label AWB pada halaman detail order.
- QR Code generator untuk nomor resi.
- Tombol cetak label dengan print iframe khusus.
- Template cetak berisi:
  - Data pengirim
  - Data penerima
  - No AWB
  - Metode pembayaran
  - Berat, koli, harga/kg
  - Total ongkir

## 5. Fitur Admin - Tracking Internal

- Halaman tracking admin untuk pencarian resi.
- Menampilkan detail tracking per order.
- Pencarian dan penelusuran status pengiriman dari sisi admin.

## 6. Fitur Admin - Courier Update

- Halaman daftar order untuk kebutuhan kurir.
- Pencarian order berdasarkan resi atau nama penerima.
- Update log tracking per order dengan field:
  - status
  - lokasi
  - deskripsi
  - foto bukti (opsional)
- Validasi upload foto:
  - wajib file image
  - maksimal 2 MB
- Penyimpanan foto ke storage public/tracking-images.
- Update current_status order sesuai status terbaru log.
- Jika status Delivered, pod_receiver_name otomatis diisi nama penerima.

## 7. Fitur POD dan Bukti Foto

- Model order sudah memiliki kolom POD:
  - pod_photo
  - pod_signature
  - pod_receiver_name
- Menampilkan foto POD di detail order (jika tersedia).
- Preview foto POD dengan overlay card + tombol silang (X).
- Menampilkan foto bukti pada log tracking (admin dan public) jika tersedia.

## 8. Fitur Admin - Billing

- Halaman billing untuk pantau pembayaran order.
- Pencarian billing berdasarkan resi, nama pengirim, atau nama penerima.
- Update status pembayaran order:
  - Lunas
  - Tagihan
- Simpan catatan billing (billing_notes).

## 9. Fitur Admin - Data Pengirim & Penerima

- Halaman daftar data pengirim dari histori order.
- Halaman daftar data penerima dari histori order.
- Data ditampilkan unik berdasarkan nomor telepon.
- Dukungan pagination.

## 10. Fitur Admin - Manajemen User

- Daftar user admin.
- Tambah user admin baru.
- Edit user admin.
- Hapus user admin.
- Proteksi agar tidak bisa menghapus satu-satunya admin tersisa.
- Password di-hash saat create/update.

## 11. Fitur Master Data Lokasi Indonesia

- Model lokasi berjenjang:
  - Province
  - City
  - District
  - Village
- API cascade dropdown:
  - GET /api/locations/cities/{province}
  - GET /api/locations/districts/{city}
  - GET /api/locations/villages/{district}
- Seeder lokasi berbasis CSV dengan batch insert skala besar.

## 12. Data Awal (Seeder)

- Seeder admin default:
  - email: admin@logitrack.id
  - role: admin
- Seeder lokasi Indonesia dari file CSV.
- Seeder contoh order + tracking logs untuk simulasi alur pengiriman.

## 13. Arsitektur Akses Route

- Route public:
  - /
  - /track
- Route auth:
  - /login
  - /logout
- Route admin dilindungi middleware auth dengan prefix /admin.

## 14. Catatan Teknis Tambahan

- Relasi utama:
  - Order hasMany TrackingLog
  - TrackingLog belongsTo Order
- Casting tanggal log tracking sebagai datetime.
- Weight pada order dicast ke decimal 2 digit.
- UI menggunakan Blade + Tailwind + Alpine.js.

---

Jika dibutuhkan, dokumen ini bisa dilanjutkan ke versi berikutnya:
- matriks fitur vs role
- status implementasi (done/in-progress)
- daftar endpoint lengkap + payload contoh
- daftar test case per fitur
