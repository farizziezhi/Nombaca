# Database Schema, Migrations & Models Blueprint
**Proyek:** NOMBACA (Sistem Manajemen Perpustakaan Digital)

Dokumen ini adalah SUMBER KEBENARAN TUNGGAL (*Single Source of Truth*) untuk pembuatan struktur *Migration* dan *Eloquent Model* di Laravel 13. AI Agent WAJIB mengikuti tipe data, penamaan kolom, dan relasi di bawah ini secara presisi.

## 1. Tabel `users` (Pengguna & Hak Akses)
Tabel ini menyimpan data autentikasi dan level akses sistem.
**Migration Structure:**
- `id`: Primary Key (BigInt / UUID).
- `name`: string.
- `email`: string, unique.
- `password`: string.
- `role`: enum('admin', 'petugas', 'user') -> *Default value wajib disetel ke 'user'*.
- `timestamps`.
**Eloquent Model (`User`):**
- **Fillable:** `name`, `email`, `password`, `role`.
- **Relasi:** `hasMany(Borrowing::class)`.

## 2. Tabel `categories` (Master Kategori Buku)
**Migration Structure:**
- `id`: Primary Key.
- `name`: string.
- `timestamps`.
**Eloquent Model (`Category`):**
- **Fillable:** `name`.
- **Relasi:** `hasMany(Book::class)`.

## 3. Tabel `books` (Katalog Inventaris)
**Migration Structure:**
- `id`: Primary Key.
- `category_id`: foreignId -> Terhubung ke tabel `categories`. **WAJIB** menggunakan `constrained()->restrictOnDelete()` untuk mencegah kategori dihapus jika masih ada buku di dalamnya.
- `title`: string.
- `author`: string.
- `stock`: integer (unsigned, tidak boleh minus).
- `isbn`: string, unique. **WAJIB** ditambahkan *database indexing* (`->index()`) untuk mempercepat pencarian (optimasi HDD).
- `timestamps`.
**Eloquent Model (`Book`):**
- **Fillable:** `category_id`, `title`, `author`, `stock`, `isbn`.
- **Relasi:** `belongsTo(Category::class)`, `hasMany(Borrowing::class)`.
- *Instruksi Khusus AI:* Saat melakukan *query* pengambilan data buku untuk ditampilkan ke *view*, WAJIB menggunakan Eager Loading `with('category')`.

## 4. Tabel `borrowings` (Riwayat Transaksi)
Tabel ini adalah inti pergerakan sirkulasi perpustakaan.
**Migration Structure:**
- `id`: Primary Key.
- `user_id`: foreignId -> Terhubung ke `users`. WAJIB `restrictOnDelete()`. Tambahkan *indexing*.
- `book_id`: foreignId -> Terhubung ke `books`. WAJIB `restrictOnDelete()`.
- `borrow_date`: date.
- `due_date`: date.
- `return_date`: date, nullable (kosong jika buku belum dikembalikan).
- `status`: enum('pending', 'active', 'returned', 'overdue') -> *Default value: 'pending'*. Tambahkan *indexing* pada kolom ini.
- `fine`: integer (unsigned) -> *Default value: 0*. (Mencatat nominal denda berjalan).
- `timestamps`.
**Eloquent Model (`Borrowing`):**
- **Fillable:** `user_id`, `book_id`, `borrow_date`, `due_date`, `return_date`, `status`, `fine`.
- **Relasi:** `belongsTo(User::class)`, `belongsTo(Book::class)`, `hasOne(Fine::class)`.
- **Casting:** Kolom `borrow_date`, `due_date`, dan `return_date` wajib di-*cast* sebagai `datetime` atau `date` di dalam Model.

## 5. Tabel `fines` (Tagihan Denda Keterlambatan)
Tabel ini digunakan untuk memisahkan logika pelunasan denda agar rekap keuangan perpustakaan lebih mudah dilacak oleh Admin.
**Migration Structure:**
- `id`: Primary Key.
- `borrowing_id`: foreignId -> Terhubung ke `borrowings`. WAJIB `restrictOnDelete()`.
- `amount`: integer (unsigned). (Total tagihan denda yang harus dibayar).
- `status`: enum('unpaid', 'paid') -> *Default value: 'unpaid'*.
- `timestamps`.
**Eloquent Model (`Fine`):**
- **Fillable:** `borrowing_id`, `amount`, `status`.
- **Relasi:** `belongsTo(Borrowing::class)`.