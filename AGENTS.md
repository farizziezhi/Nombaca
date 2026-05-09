# AI Agent Root Rules (Proyek NOMBACA)

Sebagai AI Agent pengembang sistem backend dan frontend untuk proyek NOMBACA, Anda WAJIB mematuhi instruksi mutlak berikut sebelum menulis atau mengubah baris kode apa pun:

1. **Konsistensi Dokumen (Single Source of Truth):** 
   Selalu baca dan patuhi file di folder `docs/` (`prd.md`, `architecture.md`, `schema.md`, `todo.md`, `ui-ux-guidelines.md`). DILARANG membuat tabel, relasi, tipe data, atau logika bisnis yang melenceng dari dokumen tersebut.

2. **Arsitektur Full Page Reload (Tanpa API):**
   Aplikasi ini menggunakan Laravel Blade standar dengan form submission (*Full Page Reload*). 
   - DILARANG membuat endpoint API (`routes/api.php`) atau merespons menggunakan JSON.
   - WAJIB merespons aksi form menggunakan `return redirect()->back()->with('success', 'Pesan')` atau mengalihkan ke rute yang relevan.

3. **Optimasi Penyimpanan HDD (Krusial & Harga Mati):**
   Server menjalankan database pada media penyimpanan HDD fisik. Anda DILARANG KERAS membiarkan masalah N+1 Query terjadi. 
   - WAJIB menggunakan metode Eager Loading `with()` saat mengambil relasi Eloquent yang akan di-looping di Blade (misal: memuat `category` pada `books`).
   - WAJIB memastikan migration memiliki `$table->index()` pada kolom pencarian utama.

4. **Integritas Konkurensi & Transaksi:**
   Setiap logika peminjaman buku yang melibatkan pengurangan stok wajib dibungkus di dalam `DB::transaction()` dan menggunakan `lockForUpdate()` pada row buku untuk mencegah *race condition* (stok minus).

5. **Standar Penulisan & Teknologi:**
   - Gunakan fitur PHP 8.3+ dan Laravel 13 (seperti *Native Attributes*, *Arrow Functions*, *Strict Types*).
   - Tulis *DocBlocks*, penamaan *commit*, dan komentar kode menggunakan Bahasa Indonesia yang baku dan jelas.
   - Wajib menggunakan `pnpm` untuk perintah terminal terkait Node.js/Frontend (Tailwind/Vite). Dilarang menggunakan `npm` atau `yarn`.