# Product Requirements Document (PRD)
**Proyek:** NOMBACA (Sistem Manajemen Perpustakaan Digital)

## 1. Deskripsi & Tujuan Sistem
NOMBACA adalah Sistem Manajemen Perpustakaan Digital yang dirancang untuk mengotomatisasi siklus peminjaman buku fisik. Sistem ini mengusung konsep *hybrid*, di mana pencarian, pemesanan (*booking*), dan administrasi denda dilakukan sepenuhnya secara digital melalui aplikasi web, sementara serah-terima buku tetap dilakukan secara fisik di lokasi perpustakaan. Tujuan utamanya adalah mencegah manipulasi data, menghilangkan kesalahan pencatatan manual (*human error*), dan mengamankan integritas stok buku.

## 2. Analisis Aktor & Hak Akses (Role-Based Access Control)
Sistem membagi tingkat otorisasi pengguna ke dalam 4 tingkatan yang ketat. Akses ini diatur menggunakan Middleware berdasarkan kolom `role` di tabel pengguna.

### A. Guest (Tamu / Pengguna Belum Login)
- **Katalog Eksplorasi:** Memiliki hak untuk melihat daftar buku, mencari berdasarkan judul/penulis, dan menyaring (*filter*) berdasarkan kategori.
- **Detail Buku:** Dapat melihat metadata (ISBN, Penulis), dan ketersediaan stok buku secara *real-time*.
- **Registrasi:** Dapat membuat akun baru yang secara *default* akan didaftarkan dengan *role* sebagai `user` (Member).

### B. Member (User / Anggota Perpustakaan)
- **Dashboard Personal:** Memiliki antarmuka khusus untuk memantau ringkasan aktivitas (jumlah buku yang sedang dipinjam, riwayat peminjaman, dan total denda yang belum dibayar).
- **Booking Peminjaman:** Dapat melakukan pemesanan buku secara mandiri. Stok buku akan otomatis terpotong dan status peminjaman menjadi `pending`.
- **Manajemen Transaksi:** Dapat melihat detail transaksi, tanggal jatuh tempo (`due_date`), dan status denda.

### C. Petugas (Operator / Front Desk)
- **Verifikasi Pengambilan:** Bertugas mengeksekusi penyerahan fisik. Petugas memverifikasi ID Peminjaman dari Member, lalu mengubah status transaksi dari `pending` menjadi `active`.
- **Verifikasi Pengembalian:** Memproses buku fisik yang dikembalikan Member. Sistem akan mengubah status menjadi `returned` dan secara otomatis mengembalikan stok buku.
- **Penerimaan Denda:** Mengelola pelunasan denda secara tunai dengan mengubah status di tabel *fines* dari `unpaid` menjadi `paid`.

### D. Admin (Kepala Perpustakaan / Super Admin)
- **Master Data Management (CRUD):** Memiliki kontrol penuh untuk menambah, mengedit, dan menghapus data Kategori, Buku, dan Pengguna.
- **Role Management:** Berhak menaikkan status seorang Member (`user`) menjadi `petugas`, atau menonaktifkan akun yang melanggar aturan.
- **Reporting:** Mampu men- *generate* dan mengekspor laporan aktivitas transaksi dan keuangan (denda) perpustakaan ke dalam format PDF.

## 3. Aturan Bisnis & Logika Sistem (Krusial untuk AI)
Aplikasi ini memiliki batasan sistem yang sangat ketat untuk menjaga ketertiban sirkulasi perpustakaan. AI WAJIB mengimplementasikan logika berikut di dalam *Service Class*:

1. **Rule Limit Peminjaman:** Seorang Member hanya diizinkan memiliki maksimal 3 (tiga) transaksi peminjaman yang berstatus `pending` atau `active` di waktu yang sama. Jika limit ini tercapai, tombol peminjaman di antarmuka harus di- *disable* dan *backend* harus menolak *request* baru.
2. **Rule Blokir Denda (Blacklist):** Jika Member memiliki sekurang-kurangnya 1 (satu) catatan denda dengan status `unpaid` di tabel `fines`, sistem wajib memblokir hak Member tersebut untuk melakukan *booking* buku baru hingga denda dilunasi.
3. **Logika Kadaluarsa Booking:** Transaksi dengan status `pending` hanya berlaku selama 24 jam. Jika Member tidak datang mengambil buku fisik kepada Petugas dalam batas waktu tersebut, sistem harus membatalkan peminjaman dan mengembalikan stok buku ke rak secara otomatis.
4. **Mesin Kalkulasi Denda (Cron Job Automation):**
   - **Pemicu:** Berjalan di latar belakang setiap hari tepat pukul 00:00 WITA.
   - **Kondisi:** Sistem memindai seluruh transaksi berstatus `active` yang tanggal berjalannya sudah melewati batas `due_date`.
   - **Aksi:** Menambahkan nominal pada kolom `fine` di tabel `borrowings`, dan mencatat tagihan baru di tabel `fines` sebesar **Rp 1.000 per hari keterlambatan**.

## 4. Kebutuhan Non-Fungsional
- **Keamanan Input:** Seluruh formulir harus diproteksi dari serangan CSRF. Input ISBN buku harus melalui validasi Regex agar formatnya konsisten.
- **Kinerja Disk (HDD Focus):** Untuk mengurangi beban *I/O disk* pada tabel yang membesar, pencarian katalog buku wajib memanfaatkan *Database Indexing* pada MySQL (khususnya untuk kolom `isbn`, `title`, dan `user_id`).