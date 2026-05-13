<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NOMBACA — Sistem Perpustakaan Digital</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-950 text-white">

    {{-- ═══════════════════════════════════════════ --}}
    {{-- NAVBAR                                      --}}
    {{-- ═══════════════════════════════════════════ --}}
    <header class="fixed top-0 inset-x-0 z-50 border-b border-white/5 bg-slate-950/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <svg class="h-7 w-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="text-lg font-bold tracking-tight">NOMBACA</span>
            </a>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-slate-400 hover:text-white transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500 transition">
                        Daftar Gratis
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- HERO                                        --}}
    {{-- ═══════════════════════════════════════════ --}}
    <section class="relative min-h-screen flex items-center pt-16 overflow-hidden">
        {{-- Background glow --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 left-1/4 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="max-w-4xl mx-auto text-center">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-4 py-1.5 text-sm font-medium text-emerald-400 mb-8">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Sistem Perpustakaan Digital Modern
                </div>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black tracking-tight leading-[1.05] mb-6">
                    Temukan Buku<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">
                        Impianmu
                    </span>
                </h1>

                <p class="text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto leading-relaxed mb-10">
                    NOMBACA hadir sebagai solusi perpustakaan digital modern. Jelajahi ribuan koleksi buku, pinjam dengan mudah, dan kelola semua dari satu platform.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('catalog') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-8 py-4 text-base font-bold text-white shadow-lg shadow-emerald-600/25 hover:bg-emerald-500 hover:-translate-y-0.5 transition-all">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Jelajahi Katalog
                    </a>
                    @guest
                    <a href="{{ route('register') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/5 px-8 py-4 text-base font-bold text-white hover:bg-white/10 hover:-translate-y-0.5 transition-all">
                        Daftar Sekarang
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    @endguest
                </div>
            </div>

            {{-- Stats --}}
            <div class="mt-20 grid grid-cols-2 gap-4 sm:grid-cols-4 max-w-3xl mx-auto">
                @php
                    $totalBooks    = \App\Models\Book::count();
                    $totalMembers  = \App\Models\User::where('role', 'user')->count();
                    $totalBorrows  = \App\Models\Borrowing::count();
                    $totalCategories = \App\Models\Category::count();
                @endphp
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-center backdrop-blur-sm">
                    <p class="text-3xl font-black text-white">{{ $totalBooks }}</p>
                    <p class="mt-1 text-sm text-slate-400">Koleksi Buku</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-center backdrop-blur-sm">
                    <p class="text-3xl font-black text-white">{{ $totalMembers }}</p>
                    <p class="mt-1 text-sm text-slate-400">Member Aktif</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-center backdrop-blur-sm">
                    <p class="text-3xl font-black text-white">{{ $totalBorrows }}</p>
                    <p class="mt-1 text-sm text-slate-400">Total Peminjaman</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-center backdrop-blur-sm">
                    <p class="text-3xl font-black text-white">{{ $totalCategories }}</p>
                    <p class="mt-1 text-sm text-slate-400">Kategori</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- FEATURES                                    --}}
    {{-- ═══════════════════════════════════════════ --}}
    <section class="py-24 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight mb-4">Semua yang Kamu Butuhkan</h2>
                <p class="text-slate-400 max-w-xl mx-auto">Platform lengkap untuk anggota, petugas, dan admin perpustakaan.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {{-- Feature 1 --}}
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6 hover:bg-white/8 hover:border-emerald-500/30 transition-all group">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 mb-4 group-hover:bg-emerald-500/20 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Katalog Lengkap</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Cari dan temukan buku berdasarkan judul, penulis, atau kategori dengan mudah dan cepat.</p>
                </div>

                {{-- Feature 2 --}}
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6 hover:bg-white/8 hover:border-blue-500/30 transition-all group">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400 mb-4 group-hover:bg-blue-500/20 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Peminjaman Online</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Pesan buku secara online, ambil di perpustakaan, dan kembalikan dengan proses yang mudah.</p>
                </div>

                {{-- Feature 3 --}}
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6 hover:bg-white/8 hover:border-violet-500/30 transition-all group">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-500/10 text-violet-400 mb-4 group-hover:bg-violet-500/20 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Laporan & Statistik</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Admin dapat melihat laporan lengkap dan mengekspor data sirkulasi dalam format PDF.</p>
                </div>

                {{-- Feature 4 --}}
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6 hover:bg-white/8 hover:border-amber-500/30 transition-all group">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 text-amber-400 mb-4 group-hover:bg-amber-500/20 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Notifikasi Jatuh Tempo</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Pantau batas waktu pengembalian buku dan status denda secara real-time di dashboard.</p>
                </div>

                {{-- Feature 5 --}}
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6 hover:bg-white/8 hover:border-red-500/30 transition-all group">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-500/10 text-red-400 mb-4 group-hover:bg-red-500/20 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Manajemen Denda</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Sistem denda otomatis untuk keterlambatan pengembalian buku dengan pencatatan yang rapi.</p>
                </div>

                {{-- Feature 6 --}}
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6 hover:bg-white/8 hover:border-teal-500/30 transition-all group">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-500/10 text-teal-400 mb-4 group-hover:bg-teal-500/20 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Multi Role</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Sistem role lengkap: Admin, Petugas, dan Member dengan hak akses yang berbeda-beda.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- CTA                                         --}}
    {{-- ═══════════════════════════════════════════ --}}
    <section class="py-24 border-t border-white/5">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-black tracking-tight mb-4">
                Siap Mulai Membaca?
            </h2>
            <p class="text-slate-400 mb-8">Bergabung sekarang dan nikmati kemudahan akses perpustakaan digital NOMBACA.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('catalog') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-8 py-4 text-base font-bold text-white hover:bg-emerald-500 transition shadow-lg shadow-emerald-600/25">
                    Lihat Katalog Buku
                </a>
                @guest
                <a href="{{ route('login') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/5 px-8 py-4 text-base font-bold text-white hover:bg-white/10 transition">
                    Masuk ke Akun
                </a>
                @endguest
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- FOOTER                                      --}}
    {{-- ═══════════════════════════════════════════ --}}
    <footer class="border-t border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="font-bold text-sm">NOMBACA</span>
            </div>
            <p class="text-xs text-slate-500">&copy; {{ date('Y') }} NOMBACA. Sistem Manajemen Perpustakaan Digital.</p>
        </div>
    </footer>

</body>
</html>
