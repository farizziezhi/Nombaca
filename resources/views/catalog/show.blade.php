<x-public-layout>
    <x-slot name="title">{{ $book->title }}</x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        {{-- Back Link --}}
        <a href="{{ route('catalog') }}" class="group inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-emerald-600 transition mb-8">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 group-hover:bg-emerald-100 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </div>
            Kembali ke Katalog
        </a>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                
                {{-- Book Cover --}}
                <div class="lg:w-5/12 bg-slate-100 flex items-center justify-center p-12 lg:p-24 relative overflow-hidden min-h-[400px]">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                             class="relative w-full max-w-[280px] aspect-[3/4] rounded-lg object-cover shadow-xl">
                    @else
                        <div class="relative w-full max-w-[280px] aspect-[3/4] rounded-lg bg-slate-900 shadow-xl flex items-center justify-center">
                            <svg class="h-24 w-24 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Book Details --}}
                <div class="lg:w-7/12 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
                    <div class="mb-4">
                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-black uppercase tracking-widest text-emerald-800">
                            {{ $book->category->name }}
                        </span>
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 leading-[1.1] tracking-tight mb-4">
                        {{ $book->title }}
                    </h1>
                    
                    <p class="text-xl sm:text-2xl font-medium text-slate-500 mb-10">{{ $book->author }}</p>
                    
                    <div class="grid grid-cols-2 gap-8 mb-12 py-8 border-y border-slate-100">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Nomor ISBN</p>
                            <p class="font-mono text-base font-semibold text-slate-900 bg-slate-50 inline-block px-2 py-1 rounded">{{ $book->isbn }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Status Ketersediaan</p>
                            @if($book->stock > 0)
                                <div class="flex items-center gap-2">
                                    <span class="relative flex h-3 w-3">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                    </span>
                                    <p class="text-base font-bold text-emerald-600">{{ $book->stock }} Buku Tersedia</p>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <span class="relative flex h-3 w-3">
                                      <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                    </span>
                                    <p class="text-base font-bold text-red-500">Stok Habis</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    @if($book->description)
                    <div class="mb-10">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Deskripsi Buku</p>
                        <p class="text-slate-600 leading-relaxed text-base">{{ $book->description }}</p>
                    </div>
                    @endif

                    {{-- Action Section --}}
                    <div class="mt-auto">
                        @guest
                            <div class="rounded-2xl bg-slate-50 p-6 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                                <div>
                                    <h4 class="font-bold text-slate-900 mb-1">Ingin meminjam buku ini?</h4>
                                    <p class="text-sm text-slate-600">Silakan masuk ke akun Anda terlebih dahulu.</p>
                                </div>
                                <a href="{{ route('login') }}" class="shrink-0 inline-flex items-center justify-center rounded-xl bg-slate-900 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-slate-800 transition">
                                    Login Sekarang
                                </a>
                            </div>
                        @endguest

                        @auth
                            @if(Auth::user()->role === 'user')
                                @if($book->stock > 0)
                                    <form method="POST" action="{{ route('borrowings.store') }}" 
                                          x-data="{ submitting: false }" @submit="submitting = true">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit"
                                                :disabled="submitting"
                                                class="inline-flex w-full sm:w-auto items-center justify-center gap-3 rounded-2xl bg-emerald-600 px-10 py-4 text-base font-bold text-white shadow-xl shadow-emerald-600/30 hover:bg-emerald-500 hover:-translate-y-1 hover:shadow-emerald-500/40 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300">
                                            <span x-show="!submitting" class="flex items-center gap-3">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Pinjam Buku Ini Sekarang
                                            </span>
                                            <span x-show="submitting" x-cloak class="flex items-center gap-3">
                                                <svg class="h-6 w-6 animate-spin" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                </svg>
                                                Memproses Peminjaman...
                                            </span>
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="inline-flex w-full sm:w-auto items-center justify-center gap-3 rounded-2xl bg-slate-100 px-10 py-4 text-base font-bold text-slate-400 cursor-not-allowed border border-slate-200">
                                        Maaf, Stok Sedang Habis
                                    </button>
                                @endif
                            @else
                                <div class="rounded-2xl bg-amber-50 p-6 border border-amber-200 flex gap-4">
                                    <div class="shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-amber-900 mb-1">Akses Terbatas</h4>
                                        <p class="text-sm text-amber-800">
                                            Akun Anda terdaftar sebagai <span class="capitalize font-semibold">{{ Auth::user()->role }}</span>. Peminjaman buku hanya dapat dilakukan oleh pengguna dengan role Member.
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
