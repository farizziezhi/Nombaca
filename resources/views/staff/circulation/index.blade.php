<x-admin-layout>
    <x-slot name="title">Meja Sirkulasi</x-slot>
    <x-slot name="header">Meja Sirkulasi</x-slot>

    <div class="space-y-6">
        {{-- ═══════════════════════════════════════════ --}}
        {{-- STAT CARDS (Ringkasan Cepat)               --}}
        {{-- ═══════════════════════════════════════════ --}}
        @php
            $pendingCount  = $borrowings->where('status', 'pending')->count();
            $activeCount   = $borrowings->where('status', 'active')->count();
            $overdueCount  = $borrowings->where('status', 'overdue')->count();
            $returnedCount = $borrowings->where('status', 'returned')->count();
        @endphp

        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            {{-- Pending --}}
            <div class="flex items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-amber-700">{{ $pendingCount }}</p>
                    <p class="text-[11px] font-medium text-amber-600">Menunggu Diambil</p>
                </div>
            </div>

            {{-- Active --}}
            <div class="flex items-center gap-3 rounded-xl border border-blue-200 bg-blue-50 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-blue-700">{{ $activeCount }}</p>
                    <p class="text-[11px] font-medium text-blue-600">Sedang Dipinjam</p>
                </div>
            </div>

            {{-- Overdue --}}
            <div class="flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-red-600">{{ $overdueCount }}</p>
                    <p class="text-[11px] font-medium text-red-500">Terlambat</p>
                </div>
            </div>

            {{-- Returned --}}
            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-emerald-700">{{ $returnedCount }}</p>
                    <p class="text-[11px] font-medium text-emerald-600">Dikembalikan</p>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- TABEL SIRKULASI                            --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-bold text-slate-900">Daftar Transaksi Peminjaman</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola pengambilan dan pengembalian buku anggota perpustakaan.</p>
            </div>

            @if($borrowings->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Tgl Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Jatuh Tempo</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Denda</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($borrowings as $borrowing)
                        <tr class="hover:bg-slate-50 transition" id="row-borrowing-{{ $borrowing->id }}">
                            {{-- Peminjam --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-600">
                                        {{ strtoupper(substr($borrowing->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">{{ $borrowing->user->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $borrowing->user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Buku --}}
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-slate-900">{{ $borrowing->book->title }}</p>
                                <p class="text-xs text-slate-500">{{ $borrowing->book->author }}</p>
                            </td>

                            {{-- Tanggal Pinjam --}}
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $borrowing->borrow_date->format('d M Y') }}
                            </td>

                            {{-- Jatuh Tempo --}}
                            <td class="px-6 py-4">
                                <span class="text-sm {{ $borrowing->status === 'overdue' ? 'font-bold text-red-600' : 'text-slate-600' }}">
                                    {{ $borrowing->due_date->format('d M Y') }}
                                </span>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4 text-center">
                                @switch($borrowing->status)
                                    @case('pending')
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 ring-1 ring-amber-200">
                                            Menunggu
                                        </span>
                                        @break
                                    @case('active')
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700 ring-1 ring-blue-200">
                                            Dipinjam
                                        </span>
                                        @break
                                    @case('overdue')
                                        <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-600 ring-1 ring-red-200">
                                            Terlambat
                                        </span>
                                        @break
                                    @case('returned')
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">
                                            Dikembalikan
                                        </span>
                                        @break
                                @endswitch
                            </td>

                            {{-- Denda --}}
                            <td class="px-6 py-4 text-right">
                                @if($borrowing->finePayment)
                                    <p class="text-sm font-semibold {{ $borrowing->finePayment->status === 'paid' ? 'text-emerald-600' : 'text-red-600' }}">
                                        Rp {{ number_format($borrowing->finePayment->amount, 0, ',', '.') }}
                                    </p>
                                    <span class="text-[10px] font-medium uppercase {{ $borrowing->finePayment->status === 'paid' ? 'text-emerald-500' : 'text-red-400' }}">
                                        {{ $borrowing->finePayment->status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-center">
                                @if($borrowing->status === 'pending')
                                    {{-- Serahkan Buku — Modal Konfirmasi --}}
                                    <x-modal-confirm
                                        title="Serahkan Buku?"
                                        body="Konfirmasi penyerahan buku '{{ $borrowing->book->title }}' kepada {{ $borrowing->user->name }}. Status akan berubah menjadi Dipinjam.">
                                        <x-slot name="trigger">
                                            <button type="button" x-on:click="open = true"
                                                    class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 shadow-sm transition"
                                                    id="btn-approve-{{ $borrowing->id }}">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Serahkan
                                            </button>
                                        </x-slot>
                                        <form method="POST" action="{{ route('staff.circulation.approve', $borrowing) }}"
                                              x-data="{ submitting: false }" @submit="submitting = true">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    :disabled="submitting"
                                                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
                                                <span x-show="!submitting">Ya, Serahkan</span>
                                                <span x-show="submitting" x-cloak class="flex items-center gap-2">
                                                    <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                    </svg>
                                                    Memproses...
                                                </span>
                                            </button>
                                        </form>
                                    </x-modal-confirm>

                                @elseif(in_array($borrowing->status, ['active', 'overdue']))
                                    {{-- Terima Pengembalian — Modal Konfirmasi --}}
                                    <x-modal-confirm
                                        title="Terima Pengembalian?"
                                        body="Konfirmasi pengembalian buku '{{ $borrowing->book->title }}' dari {{ $borrowing->user->name }}. Stok buku akan bertambah kembali.">
                                        <x-slot name="trigger">
                                            <button type="button" x-on:click="open = true"
                                                    class="inline-flex items-center gap-1.5 rounded-lg bg-slate-800 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-700 shadow-sm transition"
                                                    id="btn-return-{{ $borrowing->id }}">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                                </svg>
                                                Kembalikan
                                            </button>
                                        </x-slot>
                                        <form method="POST" action="{{ route('staff.circulation.return', $borrowing) }}"
                                              x-data="{ submitting: false }" @submit="submitting = true">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    :disabled="submitting"
                                                    class="inline-flex items-center gap-2 rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
                                                <span x-show="!submitting">Ya, Terima</span>
                                                <span x-show="submitting" x-cloak class="flex items-center gap-2">
                                                    <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                    </svg>
                                                    Memproses...
                                                </span>
                                            </button>
                                        </form>
                                    </x-modal-confirm>

                                @else
                                    <span class="text-xs text-slate-400">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center px-6 py-16">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                    <svg class="h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h4 class="mt-4 text-base font-bold text-slate-700">Belum ada transaksi</h4>
                <p class="mt-1 text-sm text-slate-400">Transaksi peminjaman akan muncul di sini setelah Member melakukan booking.</p>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
