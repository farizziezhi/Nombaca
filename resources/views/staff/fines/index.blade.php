<x-admin-layout>
    <x-slot name="title">Manajemen Denda</x-slot>
    <x-slot name="header">Manajemen Denda</x-slot>

    <div class="space-y-6">
        {{-- ═══════════════════════════════════════════ --}}
        {{-- STAT CARDS (Ringkasan Cepat)               --}}
        {{-- ═══════════════════════════════════════════ --}}
        @php
            $unpaidCount = $fines->where('status', 'unpaid')->count();
            $paidCount = $fines->where('status', 'paid')->count();
            $totalUnpaid = $fines->where('status', 'unpaid')->sum('amount');
        @endphp

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            {{-- Unpaid --}}
            <div class="flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-red-700">{{ $unpaidCount }}</p>
                    <p class="text-[11px] font-medium text-red-600">Belum Lunas</p>
                </div>
            </div>

            {{-- Paid --}}
            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-emerald-700">{{ $paidCount }}</p>
                    <p class="text-[11px] font-medium text-emerald-600">Lunas</p>
                </div>
            </div>

            {{-- Total Tagihan --}}
            <div class="flex items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-amber-700">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
                    <p class="text-[11px] font-medium text-amber-600">Total Tagihan (Belum Lunas)</p>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- TABEL DENDA                                --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-bold text-slate-900">Daftar Denda</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola denda keterlambatan pengembalian buku.</p>
            </div>

            @if($fines->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Member</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Terlambat</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Tagihan</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($fines as $fine)
                        <tr class="hover:bg-slate-50 transition">
                            {{-- Member --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-600">
                                        {{ strtoupper(substr($fine->borrowing->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">{{ $fine->borrowing->user->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $fine->borrowing->user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Buku --}}
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-slate-900">{{ $fine->borrowing->book->title }}</p>
                                <p class="text-xs text-slate-500">Jatuh Tempo: {{ $fine->borrowing->due_date->format('d M Y') }}</p>
                            </td>

                            {{-- Hari Terlambat --}}
                            <td class="px-6 py-4">
                                @php
                                    $endDate = $fine->status === 'paid' ? Carbon\Carbon::parse($fine->borrowing->return_date ?? now()) : now();
                                    $daysLate = max(0, $fine->borrowing->due_date->startOfDay()->diffInDays($endDate->startOfDay()));
                                @endphp
                                <span class="text-sm text-slate-600">{{ $daysLate }} Hari</span>
                            </td>

                            {{-- Tagihan --}}
                            <td class="px-6 py-4 text-right">
                                <p class="text-sm font-semibold {{ $fine->status === 'paid' ? 'text-emerald-600' : 'text-red-600' }}">
                                    Rp {{ number_format($fine->amount, 0, ',', '.') }}
                                </p>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4 text-center">
                                @if($fine->status === 'paid')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">
                                        Lunas
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-600 ring-1 ring-red-200">
                                        Belum Bayar
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-center">
                                @if($fine->status === 'unpaid')
                                    {{-- Lunasi Denda — Modal Konfirmasi --}}
                                    <x-modal-confirm
                                        title="Lunasi Denda?"
                                        body="Konfirmasi pembayaran denda sebesar Rp {{ number_format($fine->amount, 0, ',', '.') }} dari {{ $fine->borrowing->user->name }}.">
                                        <x-slot name="trigger">
                                            <button type="button" x-on:click="open = true"
                                                    class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 shadow-sm transition"
                                                    id="btn-pay-{{ $fine->id }}">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Lunasi Denda
                                            </button>
                                        </x-slot>
                                        <form method="POST" action="{{ route('staff.fines.pay', $fine) }}"
                                              x-data="{ submitting: false }" @submit="submitting = true">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    :disabled="submitting"
                                                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
                                                <span x-show="!submitting">Ya, Lunasi</span>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4 class="mt-4 text-base font-bold text-slate-700">Belum ada denda</h4>
                <p class="mt-1 text-sm text-slate-400">Denda akan muncul di sini jika ada keterlambatan.</p>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
