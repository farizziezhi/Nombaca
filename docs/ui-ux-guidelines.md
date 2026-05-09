# UI/UX Guidelines & Component Standards
**Proyek:** NOMBACA (Sistem Manajemen Perpustakaan Digital)

Dokumen ini adalah panduan mutlak bagi AI Agent dan *Frontend Developer* dalam merancang antarmuka pengguna (*User Interface*) dan pengalaman pengguna (*User Experience*).

## 1. Filosofi & Identitas Visual
Desain aplikasi mengutamakan performa (ringan di-render oleh Blade) dan kejelasan navigasi yang intuitif.
- **Palet Warna Utama:** 
  - *Emerald Green* (`bg-emerald-500` / `bg-emerald-600`): Digunakan khusus untuk tombol aksi positif (misal: "Pinjam Buku", "Simpan Data", dan notifikasi sukses).
  - *Deep Navy* (`bg-slate-800` / `bg-slate-900`): Digunakan untuk elemen struktural seperti *Sidebar*, *Navbar*, dan *Footer*.
  - *Crimson Red* (`bg-red-500`): Digunakan untuk peringatan, denda, dan aksi destruktif (misal: "Hapus Buku").
- **Tipografi:** Wajib menggunakan font *Sans-serif* modern bawaan Tailwind (seperti *Inter* atau *Roboto*) agar ringan dimuat.
- **Layout Dasar:**
  - **Area Publik / Member:** Menggunakan *Top Navigation Bar* agar area konten katalog buku lebih luas (menggunakan sistem *Grid*).
  - **Area Petugas / Admin:** Menggunakan *Sidebar Navigation* di sisi kiri untuk efisiensi perpindahan antar menu operasional (Master Data, Transaksi, Laporan).

## 2. Standar Teknologi & Ekosistem Frontend
Aplikasi ini DILARANG menggunakan jQuery atau *framework* JavaScript berat (seperti React/Vue).
- **Styling:** Wajib 100% menggunakan *utility classes* dari **Tailwind CSS**. Dilarang menulis CSS manual di file terpisah atau menggunakan *inline style* (`style="..."`) kecuali untuk perhitungan dinamis yang sangat mendesak.
- **Reusable UI:** Elemen yang sering diulang (seperti *Card* Katalog Buku, Tombol Primary, *Badge* Status) WAJIB diekstrak menjadi **Laravel Blade Components** (diletakkan di `resources/views/components/`) agar kode rapi dan tidak redundan.

## 3. Standar Interaktivitas Klien (Alpine.js)
Meskipun aplikasi berbasis *Full Page Reload*, antarmuka harus tetap terasa interaktif. **Alpine.js** digunakan murni untuk manipulasi DOM (visual) di sisi klien:
- **Modal Konfirmasi:** Setiap aksi penting (seperti "Hapus Data" atau "Verifikasi Pengembalian") wajib memunculkan *Modal* konfirmasi.
  - *Implementasi:* Gunakan `x-data="{ open: false }"` untuk mengontrol visibilitas. Modal wajib memiliki *overlay* gelap (`bg-black/50`) dan bisa ditutup dengan menekan tombol `ESC` di *keyboard* (`@keydown.escape.window="open = false"`).
- **Dropdown Menu:** Digunakan pada menu profil atau tombol *Action* di dalam tabel.
  - *Implementasi:* Wajib menutup otomatis jika area di luar dropdown diklik (`@click.outside="open = false"`).
- **Flash Messages (Toast Notification):** Pesan sukses/gagal dari *backend* (`session()->get('success')`) harus ditampilkan sebagai *Toast* di pojok layar.
  - *Implementasi:* Gunakan Alpine `x-init="setTimeout(() => show = false, 3000)"` agar notifikasi otomatis menghilang setelah 3 detik.

## 4. Optimasi UX untuk Server HDD (Sangat Krusial)
Karena server *database* membaca dari piringan HDD fisik, *query* yang berat atau proses penyimpanan data (terutama yang dibungkus `DB::transaction`) mungkin memakan waktu 1 hingga 3 detik sebelum halaman berhasil di-*refresh*.
- **Loading State Prevention (Pencegahan Klik Ganda):** Setiap formulir (`<form>`) WAJIB mengimplementasikan *script* Alpine.js pada tombol `submit`-nya. Saat tombol ditekan, tombol tersebut harus langsung berubah menjadi mode *disabled* dan menampilkan teks "Memproses..." atau *spinner icon*. Ini untuk mencegah Member menekan tombol "Pinjam" berkali-kali secara tidak sabar yang bisa merusak kalkulasi stok dan konkurensi di *database*.
- **Empty States yang Ramah:** Jika hasil pencarian buku kosong, atau tidak ada riwayat transaksi, JANGAN biarkan tabel atau halaman kosong melompong. Tampilkan teks ilustratif (misal: *"Belum ada riwayat peminjaman. Yuk, jelajahi katalog kami!"*) di tengah area konten.