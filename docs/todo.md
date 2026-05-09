# Task Tracker / Peta Jalan Pengerjaan
**Proyek:** NOMBACA (Sistem Manajemen Perpustakaan Digital)

Dokumen ini adalah *roadmap* langkah demi langkah. AI Agent dan *Developer* wajib menandai `[x]` pada setiap tugas yang sudah diselesaikan agar progres proyek mudah dilacak.

## Fase 1: Inisialisasi & Infrastruktur Dasar (Fokus Backend)
- [ ] **Setup Framework:** Instalasi Laravel 13 murni (`composer create-project laravel/laravel`).
- [ ] **Konfigurasi Database:** Atur koneksi ke **MySQL / MariaDB** lokal di file `.env`.
- [ ] **Autentikasi:** Instalasi Laravel Breeze menggunakan *stack* Blade standar.
- [ ] **Database Blueprint:** Buat seluruh file *Migration* beserta relasi *Foreign Key* dan indeksnya, merujuk penuh pada `schema.md`.
- [ ] **Eloquent Models:** Buat Model (`User`, `Category`, `Book`, `Borrowing`, `Fine`) lengkap dengan definisi `$fillable`, relasi antar tabel, dan aturan *Eager Loading*.
- [ ] **Data Seeder:** Buat `DatabaseSeeder` untuk mengisi 1 akun Admin, 1 akun Petugas, 2 akun User (Member), serta 5 kategori dan 20 data buku contoh (dummy data).
- [ ] **Role Management:** Buat *Middleware* khusus (misal: `RoleMiddleware`) untuk membatasi akses rute berdasarkan kolom `role` di tabel `users`.

## Fase 2: Master Data & UI/UX Dasar (Kolaborasi Full-Stack)
- [ ] **Layouting (Frontend):** Buat *Master Layout* Blade dengan Tailwind CSS. Siapkan *Navbar* untuk Member dan *Sidebar* untuk Admin/Petugas.
- [ ] **Integrasi Alpine.js (Frontend):** Siapkan komponen UI dasar (Modal Konfirmasi, Dropdown Profil, Toast Flash Message).
- [ ] **CRUD Kategori (Admin):** Buat `CategoryController`, form input, dan tabel datanya.
- [ ] **CRUD Buku (Admin):** Buat `BookController`. **WAJIB** terapkan `FormRequest` untuk validasi keunikan ISBN dan tipe data stok.
- [ ] **Katalog Publik (Guest/User):** Buat halaman *Landing Page* yang menampilkan *grid* buku. Implementasikan fitur pencarian berdasarkan judul/penulis dan *filter* kategori.

## Fase 3: Logika Inti Sirkulasi (Fokus Backend & Database)
- [ ] **Fitur Booking Buku (Member):** 
  - Buat `BorrowingController`.
  - Terapkan validasi *Limit* (maksimal 3 transaksi).
  - Terapkan validasi *Blacklist* (cek tunggakan di tabel `fines`).
  - Bungkus proses pembuatan data dan pengurangan stok menggunakan `DB::transaction()` dan `lockForUpdate()`.
- [ ] **Dashboard Member (User):** Buat halaman untuk melihat daftar buku yang sedang dipinjam (`pending` / `active`) dan daftar denda.
- [ ] **Validasi Pengambilan (Petugas):** Buat antarmuka dan logika pembaruan status peminjaman dari `pending` menjadi `active`.
- [ ] **Validasi Pengembalian (Petugas):** Buat logika pengembalian buku. Status menjadi `returned` dan stok buku dikembalikan.

## Fase 4: Otomatisasi, Laporan, & Finalisasi (Penyelesaian)
- [ ] **Cron Job Denda (Backend):** Buat *Artisan Command* baru (misal: `php artisan app:calculate-fines`). Tulis logika untuk mencari transaksi `active` yang melewati `due_date`, tambahkan Rp 1.000/hari, dan catat di tabel `fines`. Jadwalkan di `routes/console.php` agar berjalan otomatis pukul 00:00 WITA.
- [ ] **Pelunasan Denda (Petugas):** Buat tombol dan fungsi untuk mengubah status `fines` menjadi `paid`.
- [ ] **Ekspor PDF (Admin):** Integrasikan *package* seperti `barryvdh/laravel-dompdf` untuk mengekspor rekap transaksi per bulan.
- [ ] **Optimasi UX (Frontend):** Pastikan semua tombol *submit* pada form *booking* dan validasi sudah diatur oleh Alpine.js agar otomatis *disabled* saat diklik untuk mencegah duplikasi *request* ke HDD.

## Fase Ekstra (Penyesuaian Evaluasi UML)
- [x] **Detail Buku (Katalog Publik):** Route Model Binding + Eager Loading (`/katalog/{book:isbn}`).
- [x] **Kelola User (Area Admin):** Update Role via Alpine.js Modal/Dropdown (`/admin/users`).
- [x] **Kelola Stok (Area Petugas):** Penyesuaian Manual Stok Fisik Buku (`/staff/inventory`).