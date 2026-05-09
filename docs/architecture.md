# Architecture & Tech Stack Guidelines
**Proyek:** NOMBACA (Sistem Manajemen Perpustakaan Digital)

## 1. Spesifikasi Teknologi Inti (TALL-A Stack)
Aplikasi ini dikembangkan dengan pendekatan *Server-Side Rendered* (SSR) yang mengutamakan kestabilan dan kemudahan pemeliharaan kode.
- **Backend Framework:** PHP 8.3+ & Laravel 13.
- **Frontend Engine:** Laravel Blade Template (Pendekatan *Full Page Reload* klasik dengan form submission).
- **CSS Framework:** Tailwind CSS (dikompilasi menggunakan Vite).
- **Interactivity (Client-Side):** Alpine.js. Digunakan secara minimalis murni untuk mengelola *state* UI sisi klien yang tidak membutuhkan komunikasi ke server (contoh: membuka/menutup *dropdown*, memunculkan *modal* konfirmasi, dan menghilangkan *flash message/toast* secara otomatis).
- **Database Relasional:** MySQL atau MariaDB (Local Database Environment).
- **Authentication:** Laravel Breeze (menggunakan *stack* Blade standar bawaan).
- **Package Manager:** Wajib menggunakan `pnpm` untuk pengelolaan dependensi Node.js. Penggunaan `npm` atau `yarn` dilarang untuk menjaga konsistensi *lockfile*.

## 2. Pola Arsitektur & Desain Kode (Design Patterns)
Pemisahan tanggung jawab (*Separation of Concerns*) wajib diterapkan secara ketat.
- **Service Pattern (Wajib):** Logika bisnis tidak boleh mengotori Controller. Semua proses yang kompleks (seperti kalkulasi denda, validasi stok harian, dan siklus peminjaman buku) WAJIB diletakkan di dalam Service Classes tersendiri (misal: `App\Services\BorrowingService.php`).
- **Thin Controllers:** Controller hanya berfungsi sebagai jembatan. Tugasnya dibatasi pada: memanggil Form Request, menginjeksi Service, dan me-render View Blade (atau me-return *redirect*).
- **Form Requests:** Semua validasi input dari interaksi pengguna (termasuk validasi keunikan ISBN, format email, dan batas karakter) WAJIB menggunakan kelas `FormRequest` terpisah (misal: `StoreBookRequest`). Dilarang melakukan validasi langsung di dalam Controller.

## 3. Optimasi Infrastruktur & Kinerja Perangkat Keras
Mengingat aplikasi ini dikembangkan dan dijalankan pada lingkungan server dengan media penyimpanan **HDD konvensional** (bukan SSD), optimasi *I/O disk* adalah prioritas utama.
- **Pencegahan N+1 Query (Harga Mati):** AI WAJIB menggunakan teknik Eager Loading `with()` pada setiap *query* Eloquent yang memiliki relasi. (Contoh: Saat memuat daftar buku, wajib menggunakan `Book::with('category')->get()` agar database tidak dipaksa melakukan *query* berulang kali yang akan menyiksa kecepatan putaran HDD).
- **Database Indexing:** Kolom yang sering dijadikan parameter pencarian atau filter wajib diberikan *index* pada file *migration* (misalnya kolom `isbn` pada tabel buku, dan `user_id` pada tabel peminjaman) untuk mempercepat proses *lookup* data.

## 4. Keamanan Transaksi & Konkurensi
- **Database Transactions:** Setiap operasi yang mengubah lebih dari satu tabel secara bersamaan (misal: menyimpan data peminjaman DAN memotong stok buku) WAJIB dibungkus menggunakan `DB::transaction()`. Jika salah satu gagal, seluruh proses harus di-*rollback*.
- **Pessimistic Locking:** Untuk mencegah *race condition* (kondisi di mana dua pengguna meminjam buku terakhir secara bersamaan), logika pengecekan dan pengurangan stok fisik WAJIB menggunakan metode `lockForUpdate()` pada *query builder*.
- **Integritas Relasi:** Semua *Foreign Key* wajib menggunakan `onDelete('restrict')` untuk mencegah terhapusnya data master yang masih memiliki riwayat transaksi (misal: kategori tidak bisa dihapus jika masih ada buku di dalamnya).