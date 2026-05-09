<x-admin-layout>
    <x-slot name="header">Edit Kategori</x-slot>

    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">Edit Kategori</h2>
            <p class="mt-1 text-sm text-slate-500">Perbarui nama kategori &laquo;{{ $category->name }}&raquo;.</p>

            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="mt-6 space-y-5"
                  x-data="{ submitting: false }" @submit="submitting = true">
                @csrf
                @method('PUT')

                {{-- Nama Kategori --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Nama Kategori</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                           class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                           required autofocus>
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            :disabled="submitting"
                            class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition"
                            id="btn-update-category">
                        <span x-show="!submitting">Perbarui</span>
                        <span x-show="submitting" x-cloak class="flex items-center gap-2">
                            <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                       class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
