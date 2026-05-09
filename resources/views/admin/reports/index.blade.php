<x-admin-layout>
    <x-slot name="title">Laporan Sistem</x-slot>
    <x-slot name="header">Laporan Sistem & Sirkulasi</x-slot>

    <div class="mx-auto max-w-5xl space-y-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Rekapitulasi Data NOMBACA</h2>
                <p class="mt-1 text-sm text-slate-500">Unduh laporan resmi seluruh aktivitas sirkulasi dan denda dalam format PDF.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3 mt-4 sm:mt-0">
                <a href="{{ route('admin.reports.export') }}" target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all group">
                    <svg class="h-5 w-5 text-slate-400 group-hover:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Buka Viewer
                </a>

                <a href="{{ route('admin.reports.export', ['download' => 'true']) }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 font-semibold text-white shadow-sm hover:bg-emerald-700 hover:shadow transition-all group">
                    <svg class="h-5 w-5 transition-transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            
            {{-- Total Peminjaman --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3 text-slate-500 mb-3">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-sm font-semibold uppercase tracking-wider">Total Transaksi</h3>
                </div>
                <p class="text-3xl font-bold text-slate-900">{{ $totalBorrowings }}</p>
            </div>

            {{-- Sedang Dipinjam --}}
            <div class="rounded-xl border border-blue-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3 text-blue-500 mb-3">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-sm font-semibold uppercase tracking-wider">Sedang Dipinjam</h3>
                </div>
                <p class="text-3xl font-bold text-blue-700">{{ $totalActive }}</p>
            </div>

            {{-- Denda Terkumpul --}}
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
                <div class="flex items-center gap-3 text-emerald-600 mb-3">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-sm font-semibold uppercase tracking-wider">Pendapatan Denda</h3>
                </div>
                <p class="text-2xl font-bold text-emerald-700">Rp {{ number_format($totalFinesCollected, 0, ',', '.') }}</p>
            </div>

            {{-- Potensi Denda --}}
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
                <div class="flex items-center gap-3 text-amber-600 mb-3">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-sm font-semibold uppercase tracking-wider">Tagihan Menunggak</h3>
                </div>
                <p class="text-2xl font-bold text-amber-700">Rp {{ number_format($totalFinesPending, 0, ',', '.') }}</p>
            </div>

        </div>

        {{-- Info Panel --}}
        <div class="rounded-xl bg-slate-50 p-5 border border-slate-200 text-sm text-slate-600">
            <h4 class="font-bold text-slate-800 mb-2">Informasi Ekspor PDF</h4>
            <ul class="list-disc pl-5 space-y-1">
                <li>Laporan akan menampilkan seluruh riwayat transaksi sirkulasi dari awal perpustakaan beroperasi.</li>
                <li>Halaman dicetak dengan format Kertas A4 (Landscape) agar tabel transaksi lebih rapi.</li>
                <li>Denda yang ditampilkan sudah termasuk riwayat pelunasan oleh petugas.</li>
            </ul>
        </div>
    </div>
</x-admin-layout>
