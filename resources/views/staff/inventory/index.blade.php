<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    Manajemen Stok Buku
                </h2>
                <p class="text-sm text-slate-500 mt-1">Penyesuaian stok fisik buku di perpustakaan.</p>
            </div>
            
            {{-- Search Bar --}}
            <form method="GET" action="{{ route('staff.inventory.index') }}" class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul atau ISBN..." 
                       class="w-full rounded-xl border-slate-200 bg-white py-2 pl-10 pr-4 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200">
                
                @if($books->isEmpty())
                    <div class="p-12 text-center">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 mb-4">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">Tidak ada data</h3>
                        <p class="text-slate-500">
                            @if($search)
                                Tidak menemukan buku dengan kata kunci "{{ $search }}".
                            @else
                                Belum ada data buku di sistem.
                            @endif
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-semibold">Buku</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">ISBN</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Stok Saat Ini</th>
                                    <th scope="col" class="px-6 py-4 font-semibold text-right">Ubah Stok</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($books as $book)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-slate-900 line-clamp-1" title="{{ $book->title }}">
                                                {{ $book->title }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-mono text-xs">
                                            {{ $book->isbn }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($book->stock > 5)
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                    <div class="h-1.5 w-1.5 rounded-full bg-emerald-500"></div>
                                                    {{ $book->stock }}
                                                </span>
                                            @elseif($book->stock > 0)
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                                    <div class="h-1.5 w-1.5 rounded-full bg-amber-500"></div>
                                                    {{ $book->stock }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                                    <div class="h-1.5 w-1.5 rounded-full bg-red-500"></div>
                                                    Habis
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div x-data="{ open: false, stock: {{ $book->stock }} }">
                                                <button @click="open = true" class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition">
                                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                    Sesuaikan
                                                </button>

                                                {{-- Modal Edit Stok --}}
                                                <div x-show="open" style="display: none;" class="relative z-50 text-left" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>
                                                    
                                                    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                                                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                                            <div x-show="open"
                                                                 @click.away="open = false"
                                                                 x-transition:enter="ease-out duration-300"
                                                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                                 x-transition:leave="ease-in duration-200"
                                                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                                                
                                                                <form method="POST" action="{{ route('staff.inventory.update', $book) }}" x-data="{ submitting: false }" @submit="submitting = true">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                                                        <div class="sm:flex sm:items-start">
                                                                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                                <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                                                                </svg>
                                                                            </div>
                                                                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                                                                <h3 class="text-base font-semibold leading-6 text-slate-900" id="modal-title">Sesuaikan Stok Buku</h3>
                                                                                <div class="mt-2">
                                                                                    <p class="text-sm text-slate-500 mb-4">{{ $book->title }} ({{ $book->isbn }})</p>
                                                                                    
                                                                                    <div class="mt-4">
                                                                                        <label for="stock_{{ $book->id }}" class="block text-sm font-medium leading-6 text-slate-900">Jumlah Stok Fisik</label>
                                                                                        <div class="mt-2">
                                                                                            <input type="number" min="0" name="stock" id="stock_{{ $book->id }}" x-model="stock" class="block w-full rounded-xl border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                                                        <button type="submit" x-bind:disabled="submitting" class="inline-flex w-full justify-center rounded-xl bg-emerald-600 px-3 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 sm:ml-3 sm:w-auto transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                                                            <span x-show="!submitting">Simpan Perubahan</span>
                                                                            <span x-show="submitting" x-cloak class="flex items-center gap-2">
                                                                                <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                                                </svg>
                                                                                Menyimpan...
                                                                            </span>
                                                                        </button>
                                                                        <button type="button" @click="open = false; stock = {{ $book->stock }}" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2.5 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">Batal</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($books->hasPages())
                        <div class="border-t border-slate-200 px-6 py-4">
                            {{ $books->links() }}
                        </div>
                    @endif
                @endif
                
            </div>
        </div>
    </div>
</x-admin-layout>
