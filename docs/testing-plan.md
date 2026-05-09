# Testing Plan & Skenario Edge Cases
**Proyek:** NOMBACA

Dokumen ini mendefinisikan skenario pengujian ekstrem untuk membuktikan bahwa sistem stabil, aman dari manipulasi ganda, dan teroptimasi untuk lingkungan HDD lokal.

## 1. Pengujian Konkurensi Database (Pessimistic Locking Test)
- **Skenario:** Cari buku yang sisa stoknya hanya 1. Buka 2 tab *browser* dengan 2 akun Member berbeda. Klik tombol "Pinjam" secara bersamaan di kedua tab.
- **Ekspektasi Hasil:** Berkat implementasi `lockForUpdate()` dan `DB::transaction()`, Member pertama akan berhasil meminjam, sedangkan Member kedua akan menerima pesan *error* "Stok habis", dan stok di *database* menjadi 0 (tidak boleh menjadi -1).

## 2. Pengujian Aturan Bisnis (Business Rule Validation)
- **Limit Pinjam (Maks 3 Buku):** Gunakan akun Member yang sudah memiliki 3 peminjaman aktif. Coba pinjam buku ke-4.
  - *Ekspektasi:* Sistem melempar *error* validasi, transaksi gagal.
- **Blokir Denda (Blacklist):** Ubah manual status denda salah satu Member di *database* menjadi `unpaid`. Login menggunakan akun tersebut dan coba lakukan pemesanan buku baru.
  - *Ekspektasi:* Sistem menolak proses dan mengembalikan pesan *"Selesaikan denda Anda terlebih dahulu"*.

## 3. Pengujian Otomatisasi & Simulasi Waktu (Cron Job Test)
- **Skenario:** Ubah tanggal `due_date` pada salah satu transaksi berstatus `active` di *database* menjadi 2 hari yang lalu (H-2). Jalankan perintah terminal `php artisan app:calculate-fines` secara manual.
- **Ekspektasi Hasil:** 
  1. Tabel `borrowings` pada kolom `fine` bertambah menjadi Rp 2.000.
  2. Muncul baris data baru di tabel `fines` dengan jumlah tagihan Rp 2.000 dan status `unpaid`.

## 4. Pengujian Kinerja Perangkat Keras (HDD I/O Optimization)
- **Skenario:** Instal dan nyalakan *package* `barryvdh/laravel-debugbar`. Buka halaman Katalog Publik yang menampilkan daftar puluhan buku beserta nama kategorinya.
- **Ekspektasi Hasil:** Berkat implementasi Eager Loading (`with('category')`), jumlah *query database* yang tercatat pada panel Debugbar harus tetap berada di kisaran 2 hingga 4 *queries* saja, tanpa peduli apakah ada 10 atau 100 buku yang ditampilkan (bebas dari masalah N+1 Query).

## 5. Pengujian Keamanan Akses (Middleware Bypass)
- **Skenario:** Login sebagai Member biasa (User). Ketikkan secara paksa URL `/admin/books/create` di kolom alamat peramban web.
- **Ekspektasi Hasil:** Sistem mengembalikan halaman *403 Forbidden* atau me-*redirect* Member kembali ke *Dashboard* utamanya.