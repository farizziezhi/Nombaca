<x-admin-layout>
    <x-slot name="header">Tambah Buku</x-slot>

    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">Buku Baru</h2>
            <p class="mt-1 text-sm text-slate-500">Tambahkan buku baru ke inventaris perpustakaan.</p>

            <form method="POST" action="{{ route('admin.books.store') }}" class="mt-6 space-y-5"
                  enctype="multipart/form-data"
                  x-data="{ submitting: false }" @submit="submitting = true">
                @csrf

                {{-- Cover Buku --}}
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-slate-700">Sampul Buku <span class="text-slate-400 font-normal">(opsional, maks 2MB)</span></label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/*"
                           class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-700 hover:file:bg-emerald-100">
                    @error('cover_image')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Judul --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700">Judul Buku</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                           placeholder="contoh: Laskar Pelangi" required autofocus>
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Penulis --}}
                <div>
                    <label for="author" class="block text-sm font-medium text-slate-700">Penulis</label>
                    <input type="text" name="author" id="author" value="{{ old('author') }}"
                           class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                           placeholder="contoh: Andrea Hirata" required>
                    @error('author')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ISBN & Stok (side-by-side) --}}
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-slate-700">ISBN</label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                               class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm font-mono"
                               placeholder="contoh: 9789793062792" required>
                        @error('isbn')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-medium text-slate-700">Stok</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', 1) }}"
                               class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                               min="0" required>
                        @error('stock')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-700">Kategori</label>
                    <select name="category_id" id="category_id"
                            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                            required>
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700">Deskripsi / Sinopsis <span class="text-slate-400 font-normal">(opsional)</span></label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                              placeholder="Tulis sinopsis atau deskripsi singkat buku...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            :disabled="submitting"
                            class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition"
                            id="btn-submit-book">
                        <span x-show="!submitting">Simpan Buku</span>
                        <span x-show="submitting" x-cloak class="flex items-center gap-2">
                            <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>
                    <a href="{{ route('admin.books.index') }}"
                       class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
