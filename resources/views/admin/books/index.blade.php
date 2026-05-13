<x-admin-layout>
    <x-slot name="header">Kelola Buku</x-slot>

    <div class="space-y-6">
        {{-- Header Bar --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Daftar Buku</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola inventaris buku perpustakaan. Total: {{ $books->count() }} buku.</p>
            </div>
            <a href="{{ route('admin.books.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition"
               id="btn-create-book">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Buku
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Cover</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Penulis</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">ISBN</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Kategori</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Stok</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($books as $index => $book)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="cover" class="h-12 w-8 rounded object-cover shadow">
                                @else
                                    <div class="h-12 w-8 rounded bg-slate-200 flex items-center justify-center">
                                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-slate-900">{{ $book->title }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $book->author }}</td>
                            <td class="px-6 py-4">
                                <code class="rounded bg-slate-100 px-2 py-0.5 text-xs font-mono text-slate-600">{{ $book->isbn }}</code>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                    {{ $book->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($book->stock > 3)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700">{{ $book->stock }}</span>
                                @elseif($book->stock > 0)
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-bold text-amber-700">{{ $book->stock }}</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-bold text-red-600">Habis</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.books.edit', $book) }}"
                                       class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50 transition"
                                       id="btn-edit-book-{{ $book->id }}">
                                        Edit
                                    </a>
                                    <x-modal-confirm
                                        title="Hapus Buku?"
                                        body="Apakah Anda yakin ingin menghapus buku &laquo;{{ $book->title }}&raquo;? Buku yang masih memiliki riwayat peminjaman tidak bisa dihapus.">
                                        <x-slot name="trigger">
                                            <button type="button" x-on:click="open = true"
                                                    class="rounded-lg border border-red-300 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 transition"
                                                    id="btn-delete-book-{{ $book->id }}">
                                                Hapus
                                            </button>
                                        </x-slot>
                                        <form method="POST" action="{{ route('admin.books.destroy', $book) }}" x-data="{ submitting: false }" @submit="submitting = true">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" x-bind:disabled="submitting"
                                                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition">
                                                <span x-show="!submitting">Ya, Hapus</span>
                                                <span x-show="submitting" x-cloak>Menghapus...</span>
                                            </button>
                                        </form>
                                    </x-modal-confirm>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <p class="mt-3 text-sm font-medium text-slate-500">Belum ada buku terdaftar.</p>
                                <p class="mt-1 text-xs text-slate-400">Klik "Tambah Buku" untuk memulai.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
