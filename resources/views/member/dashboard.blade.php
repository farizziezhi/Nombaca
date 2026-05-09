<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-emerald-600 mb-1">Halo, {{ Auth::user()->name }} 👋</p>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Dashboard Peminjaman</h2>
            </div>
            <a href="{{ route('catalog') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-800 shadow-sm transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Cari Buku Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ═══════════════════════════════════════════ --}}
            {{-- STAT CARDS                                 --}}
            {{-- ═══════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $pending  = $borrowings->where('status', 'pending')->count();
                    $active   = $borrowings->where('status', 'active')->count();
                    $returned = $borrowings->where('status', 'returned')->count();
                    $unpaidFines = $borrowings->sum(function($b) {
                        return ($b->finePayment && $b->finePayment->status === 'unpaid') ? $b->finePayment->amount : 0;
                    });
                @endphp

                {{-- Pending --}}
                <div class="flex items-center gap-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-amber-600 shadow-inner">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $pending }}</p>
                        <p class="text-sm font-bold text-slate-500">Menunggu</p>
                    </div>
                </div>

                {{-- Active --}}
                <div class="flex items-center gap-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-blue-600 shadow-inner">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $active }}</p>
                        <p class="text-sm font-bold text-slate-500">Dipinjam</p>
                    </div>
                </div>

                {{-- Returned --}}
                <div class="flex items-center gap-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-emerald-600 shadow-inner">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $returned }}</p>
                        <p class="text-sm font-bold text-slate-500">Dikembalikan</p>
                    </div>
                </div>

                {{-- Fines --}}
                <div class="flex items-center gap-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-red-600 shadow-inner">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-2xl font-black text-slate-900 tracking-tight truncate">Rp {{ number_format($unpaidFines, 0, ',', '.') }}</p>
                        <p class="text-sm font-bold text-slate-500 truncate">Total Denda</p>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════ --}}
            {{-- BORROWING TIMELINE CARDS                   --}}
            {{-- ═══════════════════════════════════════════ --}}
            <div class="mt-8">
                <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Aktivitas Peminjaman Anda
                </h3>

                @if($borrowings->count())
                    <div class="space-y-4">
                        @foreach($borrowings as $borrowing)
                            @php
                                $now = now();
                                $dueDate = \Carbon\Carbon::parse($borrowing->due_date);
                                $daysLeft = $now->diffInDays($dueDate, false);
                                $isOverdue = $daysLeft < 0 && $borrowing->status !== 'returned';
                            @endphp

                            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col md:flex-row md:items-center justify-between gap-6">
                                
                                {{-- Main Info --}}
                                <div class="flex-1 pl-2">
                                    <div class="flex items-center gap-3 mb-2">
                                        @switch($borrowing->status)
                                            @case('pending')
                                                <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest bg-white border border-slate-200 text-slate-700">Menunggu</span>
                                                @break
                                            @case('active')
                                                <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest bg-white border border-slate-200 text-slate-700">Dipinjam</span>
                                                @break
                                            @case('returned')
                                                <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest bg-white border border-slate-200 text-slate-700">Dikembalikan</span>
                                                @break
                                            @case('overdue')
                                                <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest bg-white border border-slate-200 text-slate-700">Terlambat</span>
                                                @break
                                        @endswitch
                                    </div>
                                    <h4 class="text-lg font-bold text-slate-900 leading-tight mb-1">{{ $borrowing->book->title }}</h4>
                                    <p class="text-sm text-slate-500">{{ $borrowing->book->author }}</p>
                                </div>

                                {{-- Time Info --}}
                                <div class="flex-shrink-0 grid grid-cols-2 md:grid-cols-1 lg:grid-cols-2 gap-4 md:gap-2 lg:gap-6 bg-slate-50 rounded-xl p-4 border border-slate-100">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Tanggal Pinjam</p>
                                        <p class="text-sm font-semibold text-slate-700">{{ $borrowing->borrow_date->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Batas Kembali</p>
                                        <p class="text-sm font-semibold text-slate-700">{{ $borrowing->due_date->format('d M Y') }}</p>
                                    </div>
                                </div>

                                {{-- Status/Progress --}}
                                <div class="flex-shrink-0 w-full md:w-48 flex flex-col justify-center border-t border-slate-100 md:border-t-0 md:border-l md:pl-6 pt-4 md:pt-0">
                                    @if($borrowing->status === 'active')
                                        @if($daysLeft > 0)
                                            <div class="mb-1 flex justify-between items-end">
                                                <span class="text-xs font-bold text-slate-600">Sisa Waktu</span>
                                                <span class="text-sm font-black {{ $daysLeft <= 2 ? 'text-red-500' : 'text-blue-600' }}">{{ floor($daysLeft) }} Hari</span>
                                            </div>
                                            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                                @php
                                                    $totalDays = \Carbon\Carbon::parse($borrowing->borrow_date)->diffInDays($dueDate) ?: 1;
                                                    $progress = max(0, min(100, 100 - (($daysLeft / $totalDays) * 100)));
                                                @endphp
                                                <div class="h-full {{ $daysLeft <= 2 ? 'bg-red-500' : 'bg-blue-500' }} rounded-full" style="width: {{ $progress }}%"></div>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2 text-red-600 bg-red-50 px-3 py-2 rounded-lg border border-red-100">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                                <div>
                                                    <p class="text-xs font-black uppercase">Overdue</p>
                                                    <p class="text-[10px] font-semibold">Segera kembalikan!</p>
                                                </div>
                                            </div>
                                        @endif
                                    @elseif($borrowing->status === 'returned')
                                        <div class="text-right">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Dikembalikan Pada</p>
                                            <p class="text-sm font-semibold text-slate-700">{{ $borrowing->return_date->format('d M Y') }}</p>
                                        </div>
                                    @elseif($borrowing->status === 'pending')
                                        <div class="text-center md:text-right">
                                            <p class="text-sm font-bold text-amber-600">Segera ambil buku</p>
                                            <p class="text-xs text-amber-600/70">di perpustakaan</p>
                                        </div>
                                    @elseif($borrowing->status === 'overdue')
                                        <div class="text-center md:text-right">
                                            <p class="text-sm font-black text-red-600">Terlambat!</p>
                                            <p class="text-xs font-medium text-red-500">Denda berjalan</p>
                                        </div>
                                    @endif

                                    {{-- Denda Info --}}
                                    @if($borrowing->finePayment)
                                        <div class="mt-3 bg-slate-50 rounded p-2 border border-slate-200 text-center flex items-center justify-between">
                                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Denda</span>
                                            <div>
                                                <span class="text-xs font-black {{ $borrowing->finePayment->status === 'paid' ? 'text-emerald-600' : 'text-red-600' }}">
                                                    Rp {{ number_format($borrowing->finePayment->amount, 0, ',', '.') }}
                                                </span>
                                                @if($borrowing->finePayment->status !== 'paid')
                                                    <span class="ml-1 inline-flex h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="flex flex-col items-center justify-center rounded-3xl border-2 border-dashed border-slate-200 bg-white px-6 py-20">
                        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-slate-100">
                            <svg class="h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h4 class="mt-5 text-xl font-black text-slate-800">Belum ada peminjaman</h4>
                        <p class="mt-2 text-sm text-slate-500 max-w-md text-center">Anda belum meminjam buku apa pun. Jelajahi katalog kami dan temukan buku menarik untuk dibaca!</p>
                        <a href="{{ route('catalog') }}"
                           class="mt-6 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white hover:bg-emerald-500 shadow-sm transition">
                            Mulai Jelajah
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
