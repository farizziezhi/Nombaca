<x-public-layout>
    <x-slot name="title">Katalog Buku</x-slot>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- HERO SECTION                                           --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <section class="relative overflow-hidden bg-slate-950 text-white pt-24 pb-16 border-b border-slate-800">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl mb-6">
                    Temukan <span class="text-emerald-400">Inspirasi</span> Barumu
                </h1>
                <p class="text-lg text-emerald-100/80 mb-10">
                    Jelajahi ribuan koleksi buku digital dan fisik kami. Akses ilmu pengetahuan tanpa batas langsung dari genggaman Anda.
                </p>

                {{-- ═══════════════════════════════════════════ --}}
                {{-- SEARCH & FILTER FORM                       --}}
                {{-- ═══════════════════════════════════════════ --}}
                <form method="GET" action="{{ url('/') }}" 
                      class="mx-auto bg-slate-900 p-2 rounded-xl border border-slate-700 shadow-sm flex flex-col sm:flex-row gap-2"
                      x-data="{ searching: false }" @submit="searching = true">
                    
                    {{-- Search Input --}}
                    <div class="relative flex-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="block w-full h-12 rounded-lg border-0 bg-transparent py-3 pl-11 pr-4 text-white placeholder-slate-500 focus:ring-2 focus:ring-emerald-500 text-base transition"
                               placeholder="Cari judul buku atau nama penulis..."
                               id="input-search">
                    </div>

                    {{-- Category Filter --}}
                    <select name="category"
                            class="h-12 rounded-lg border-0 bg-slate-800 px-4 text-white focus:ring-2 focus:ring-emerald-500 text-base sm:w-48 transition appearance-none cursor-pointer"
                            id="select-category"
                            onchange="this.form.submit()">
                        <option value="" class="text-slate-200">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="text-slate-200"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Submit Button --}}
                    <button type="submit"
                            :disabled="searching"
                            class="h-12 inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-500 px-8 text-base font-bold text-white shadow-lg shadow-emerald-600/30 hover:bg-emerald-400 hover:shadow-emerald-500/40 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                            id="btn-search">
                        <span x-show="!searching">Cari</span>
                        <span x-show="searching" x-cloak class="flex items-center gap-2">
                            <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </span>
                    </button>
                </form>

                {{-- Active Filters Indicator --}}
                @if(request('search') || request('category'))
                <div class="mt-6 flex flex-wrap items-center justify-center gap-2 text-sm text-slate-400">
                    <span>Filter aktif:</span>
                    @if(request('search'))
                        <span class="inline-flex items-center rounded-md bg-slate-800 px-3 py-1 font-medium text-slate-200 border border-slate-700">
                            "{{ request('search') }}"
                        </span>
                    @endif
                    @if(request('category'))
                        @php $activeCategory = $categories->firstWhere('id', request('category')); @endphp
                        @if($activeCategory)
                            <span class="inline-flex items-center rounded-md bg-slate-800 px-3 py-1 font-medium text-slate-200 border border-slate-700">
                                {{ $activeCategory->name }}
                            </span>
                        @endif
                    @endif
                    <a href="{{ url('/') }}" class="ml-2 text-emerald-500 hover:text-emerald-400 underline decoration-emerald-500/30 underline-offset-4 transition">Reset Pencarian</a>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- BOOK GRID                                              --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <section class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 relative z-10">
        @if($books->count())
        {{-- Grid --}}
        <div class="grid grid-cols-2 gap-4 sm:gap-6 md:grid-cols-3 lg:grid-cols-4">
            @foreach($books as $book)
            <article class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-900/5 hover:ring-emerald-200"
                     id="book-card-{{ $book->id }}">
                
                {{-- Book Cover --}}
                <a href="{{ route('catalog.show', $book->isbn) }}" class="block aspect-[3/4] bg-slate-100 relative overflow-hidden">
                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity z-10"></div>
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                             class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-slate-300 group-hover:scale-110 transition-transform duration-500">
                            <svg class="h-16 w-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute bottom-4 left-4 right-4 translate-y-8 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all z-20">
                        <span class="block text-center text-xs font-bold text-white tracking-widest uppercase mb-2 drop-shadow-md">Lihat Detail</span>
                    </div>
                </a>

                {{-- Content --}}
                <div class="flex flex-1 flex-col p-4 sm:p-5">
                    {{-- Category Badge --}}
                    <span class="mb-2 inline-flex self-start rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-emerald-600">
                        {{ $book->category->name }}
                    </span>

                    {{-- Title --}}
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-tight line-clamp-2 mb-1 group-hover:text-emerald-700 transition-colors">
                        <a href="{{ route('catalog.show', $book->isbn) }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ $book->title }}
                        </a>
                    </h3>

                    {{-- Author --}}
                    <p class="text-xs text-slate-500 line-clamp-1">{{ $book->author }}</p>

                    <div class="flex-1"></div>

                    {{-- Stock Footer --}}
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between z-20 relative">
                        @if($book->stock > 0)
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                {{ $book->stock }} Tersedia
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-red-500">
                                <span class="relative flex h-2 w-2">
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                </span>
                                Habis
                            </span>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($books->hasPages())
        <div class="mt-12">
            {{ $books->links() }}
        </div>
        @endif

        @else
        {{-- ═══════════════════════════════════════════ --}}
        {{-- EMPTY STATE                                --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="flex flex-col items-center justify-center rounded-3xl border border-slate-200 bg-white/50 backdrop-blur-sm px-6 py-24 shadow-sm mt-8">
            <div class="flex h-24 w-24 items-center justify-center rounded-full bg-slate-100 mb-6">
                <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 text-center">Buku tidak ditemukan</h3>
            <p class="mt-2 max-w-md text-center text-base text-slate-500">
                Maaf, tidak ada buku yang cocok dengan kata kunci atau filter Anda. Coba istilah lain atau reset pencarian.
            </p>
            <a href="{{ url('/') }}"
               class="mt-8 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition">
                Reset Pencarian
            </a>
        </div>
        @endif
    </section>
</x-public-layout>
