<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">Dashboard</x-slot>

    <div class="space-y-6">

        {{-- ═══════════════════════════════════════════ --}}
        {{-- GREETING                                    --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="rounded-xl border border-slate-200 bg-white px-6 py-5 shadow-sm">
            <p class="text-sm text-slate-500">Selamat datang kembali,</p>
            <h2 class="mt-0.5 text-xl font-bold text-slate-900">{{ Auth::user()->name }} <span class="ml-2 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 capitalize">{{ Auth::user()->role }}</span></h2>
            <p class="mt-1 text-xs text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- STAT CARDS                                  --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

            {{-- Total Buku --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-500">Total Buku</p>
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                </div>
                <p class="mt-3 text-2xl font-bold text-slate-900">{{ $stats['total_books'] }}</p>
                <a href="{{ route('admin.books.index') }}" class="mt-1 text-xs text-blue-600 hover:underline">Lihat semua →</a>
            </div>

            {{-- Total Member --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-500">Total Member</p>
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <p class="mt-3 text-2xl font-bold text-slate-900">{{ $stats['total_members'] }}</p>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.users.index') }}" class="mt-1 text-xs text-violet-600 hover:underline">Kelola user →</a>
                @else
                    <p class="mt-1 text-xs text-slate-400">Anggota terdaftar</p>
                @endif
            </div>

            {{-- Sedang Dipinjam --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-500">Sedang Dipinjam</p>
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                </div>
                <p class="mt-3 text-2xl font-bold text-slate-900">{{ $stats['active_borrows'] }}</p>
                <div class="mt-1 flex items-center gap-2">
                    @if($stats['overdue'] > 0)
                        <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-0.5 text-xs font-semibold text-red-600">{{ $stats['overdue'] }} terlambat</span>
                    @endif
                    @if($stats['pending'] > 0)
                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-semibold text-amber-600">{{ $stats['pending'] }} pending</span>
                    @endif
                </div>
            </div>

            {{-- Denda Belum Dibayar --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-500">Denda Belum Bayar</p>
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="mt-3 text-2xl font-bold text-slate-900">Rp {{ number_format($stats['fines_unpaid'], 0, ',', '.') }}</p>
                <a href="{{ route('staff.fines.index') }}" class="mt-1 text-xs text-red-500 hover:underline">Kelola denda →</a>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- QUICK ACTIONS                               --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h3 class="mb-4 text-sm font-semibold text-slate-700">Aksi Cepat</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('staff.circulation.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    Meja Sirkulasi
                    @if($stats['pending'] > 0)
                        <span class="rounded-full bg-white/20 px-1.5 py-0.5 text-xs">{{ $stats['pending'] }}</span>
                    @endif
                </a>
                <a href="{{ route('staff.fines.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-slate-700 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Kelola Denda
                </a>
                <a href="{{ route('staff.inventory.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Manajemen Stok
                    @if($stats['low_stock'] > 0)
                        <span class="rounded-full bg-red-100 px-1.5 py-0.5 text-xs text-red-600">{{ $stats['low_stock'] }} menipis</span>
                    @endif
                </a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.books.create') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition shadow-sm">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Buku
                    </a>
                    <a href="{{ route('admin.reports.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition shadow-sm">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Laporan
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            {{-- ═══════════════════════════════════════════ --}}
            {{-- TRANSAKSI TERBARU                           --}}
            {{-- ═══════════════════════════════════════════ --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                    <h3 class="font-semibold text-slate-800">Transaksi Terbaru</h3>
                    <a href="{{ route('staff.circulation.index') }}" class="text-xs text-emerald-600 hover:underline">Lihat semua →</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($recentBorrowings as $b)
                    <div class="flex items-center gap-3 px-5 py-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-600">
                            {{ strtoupper(substr($b->user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-800">{{ $b->book->title }}</p>
                            <p class="text-xs text-slate-400">{{ $b->user->name }} · {{ $b->borrow_date->format('d M Y') }}</p>
                        </div>
                        @switch($b->status)
                            @case('pending')
                                <span class="shrink-0 rounded-full bg-amber-50 px-2 py-0.5 text-xs font-semibold text-amber-700">Pending</span>
                                @break
                            @case('active')
                                <span class="shrink-0 rounded-full bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-700">Dipinjam</span>
                                @break
                            @case('overdue')
                                <span class="shrink-0 rounded-full bg-red-50 px-2 py-0.5 text-xs font-semibold text-red-600">Terlambat</span>
                                @break
                            @case('returned')
                                <span class="shrink-0 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">Kembali</span>
                                @break
                        @endswitch
                    </div>
                    @empty
                    <p class="px-5 py-8 text-center text-sm text-slate-400">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </div>

            <div class="space-y-6">
                {{-- ═══════════════════════════════════════════ --}}
                {{-- STOK MENIPIS                                --}}
                {{-- ═══════════════════════════════════════════ --}}
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                        <h3 class="font-semibold text-slate-800">Stok Menipis</h3>
                        <a href="{{ route('staff.inventory.index') }}" class="text-xs text-emerald-600 hover:underline">Kelola stok →</a>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($lowStockBooks as $book)
                        <div class="flex items-center justify-between px-5 py-3">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-800">{{ $book->title }}</p>
                                <p class="text-xs text-slate-400">{{ $book->category->name }}</p>
                            </div>
                            <span class="ml-3 shrink-0 rounded-full px-2.5 py-0.5 text-xs font-bold
                                {{ $book->stock === 0 ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $book->stock }} stok
                            </span>
                        </div>
                        @empty
                        <p class="px-5 py-6 text-center text-sm text-slate-400">Semua stok aman ✓</p>
                        @endforelse
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════ --}}
                {{-- TOP MEMBER (admin only)                     --}}
                {{-- ═══════════════════════════════════════════ --}}
                @if(Auth::user()->role === 'admin')
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h3 class="font-semibold text-slate-800">Member Paling Aktif</h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($topMembers as $i => $member)
                        <div class="flex items-center gap-3 px-5 py-3">
                            <span class="w-5 shrink-0 text-center text-xs font-bold text-slate-400">{{ $i + 1 }}</span>
                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            <p class="min-w-0 flex-1 truncate text-sm text-slate-800">{{ $member->name }}</p>
                            <span class="shrink-0 text-xs font-semibold text-slate-500">{{ $member->total_borrows }}x</span>
                        </div>
                        @empty
                        <p class="px-5 py-6 text-center text-sm text-slate-400">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>
                @endif

                {{-- ═══════════════════════════════════════════ --}}
                {{-- RINGKASAN KEUANGAN (admin only)             --}}
                {{-- ═══════════════════════════════════════════ --}}
                @if(Auth::user()->role === 'admin')
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="mb-4 font-semibold text-slate-800">Ringkasan Denda</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Sudah Terkumpul</span>
                            <span class="text-sm font-bold text-emerald-600">Rp {{ number_format($stats['fines_collected'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Belum Dibayar</span>
                            <span class="text-sm font-bold text-red-600">Rp {{ number_format($stats['fines_unpaid'], 0, ',', '.') }}</span>
                        </div>
                        @php $total = $stats['fines_collected'] + $stats['fines_unpaid']; @endphp
                        @if($total > 0)
                        <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-slate-100">
                            <div class="h-2 rounded-full bg-emerald-500 transition-all"
                                 style="width: {{ round(($stats['fines_collected'] / $total) * 100) }}%"></div>
                        </div>
                        <p class="text-right text-xs text-slate-400">{{ round(($stats['fines_collected'] / $total) * 100) }}% terkumpul</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
