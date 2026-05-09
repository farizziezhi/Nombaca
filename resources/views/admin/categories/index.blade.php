<x-admin-layout>
    <x-slot name="header">Kelola Kategori</x-slot>

    <div class="space-y-6">
        {{-- Header Bar --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Daftar Kategori</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola kategori buku perpustakaan.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition"
               id="btn-create-category">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kategori
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nama Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Jumlah Buku</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $index => $category)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">
                                {{ $category->books_count }} buku
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50 transition"
                                   id="btn-edit-category-{{ $category->id }}">
                                    Edit
                                </a>
                                <x-modal-confirm
                                    title="Hapus Kategori?"
                                    body="Apakah Anda yakin ingin menghapus kategori &laquo;{{ $category->name }}&raquo;? Kategori yang masih memiliki buku tidak bisa dihapus.">
                                    <x-slot name="trigger">
                                        <button type="button" x-on:click="open = true"
                                                class="rounded-lg border border-red-300 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 transition"
                                                id="btn-delete-category-{{ $category->id }}">
                                            Hapus
                                        </button>
                                    </x-slot>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" x-data="{ submitting: false }" @submit="submitting = true">
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
                        <td colspan="4" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <p class="mt-3 text-sm font-medium text-slate-500">Belum ada kategori.</p>
                            <p class="mt-1 text-xs text-slate-400">Klik "Tambah Kategori" untuk memulai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
