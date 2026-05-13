<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'NOMBACA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen bg-slate-100">

            {{-- ═══════════════════════════════════════════ --}}
            {{-- SIDEBAR — Deep Navy (bg-slate-800/900)     --}}
            {{-- ═══════════════════════════════════════════ --}}
            <aside x-data="{ open: true }"
                   class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-slate-900 transition-transform duration-200 lg:translate-x-0"
                   :class="open ? 'translate-x-0' : '-translate-x-full'">

                {{-- Logo --}}
                <div class="flex h-16 items-center gap-2 border-b border-slate-700 px-6">
                    <svg class="h-7 w-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="text-lg font-bold text-white tracking-tight">NOMBACA</span>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
                    <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Menu Utama</p>

                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        icon='<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>'>
                        Dashboard
                    </x-sidebar-link>

                    @if(Auth::user()->role === 'admin')
                    <p class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Master Data</p>

                    <x-sidebar-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')"
                        icon='<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>'>
                        Kategori
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('admin.books.index')" :active="request()->routeIs('admin.books.*')"
                        icon='<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'>
                        Buku
                    </x-sidebar-link>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <x-sidebar-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')"
                            icon='<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'>
                            Kelola User
                        </x-sidebar-link>

                        <p class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Laporan</p>
                        
                        <x-sidebar-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')"
                            icon='<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'>
                            Laporan Sistem
                        </x-sidebar-link>
                    @endif

                    <p class="mb-2 mt-6 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Transaksi</p>

                    <x-sidebar-link :href="route('staff.circulation.index')" :active="request()->routeIs('staff.circulation.*')"
                        icon='<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>'>
                        Sirkulasi
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('staff.inventory.index')" :active="request()->routeIs('staff.inventory.*')"
                        icon='<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>'>
                        Manajemen Stok
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('staff.fines.index')" :active="request()->routeIs('staff.fines.*')"
                        icon='<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'>
                        Manajemen Denda
                    </x-sidebar-link>
                </nav>

                {{-- User Info --}}
                <div class="border-t border-slate-700 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-600 text-sm font-bold text-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="truncate text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                            <p class="truncate text-xs text-slate-400 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" x-data="{ submitting: false }" @submit="submitting = true">
                            @csrf
                            <button type="submit" x-bind:disabled="submitting" class="rounded p-1 text-slate-400 hover:bg-slate-700 hover:text-white transition" title="Logout">
                                <svg x-show="!submitting" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <svg x-show="submitting" x-cloak class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- ═══════════════════════════════════════════ --}}
            {{-- MAIN CONTENT AREA                          --}}
            {{-- ═══════════════════════════════════════════ --}}
            <div class="flex flex-1 flex-col lg:pl-64">

                {{-- Top Bar (mobile sidebar toggle + breadcrumb) --}}
                <header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b border-slate-200 bg-white px-4 sm:px-6 lg:px-8">
                    {{-- Mobile menu button --}}
                    <button @click="$dispatch('toggle-sidebar')"
                            class="rounded-md p-2 text-slate-500 hover:bg-slate-100 lg:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    @isset($header)
                        <h1 class="text-lg font-semibold text-slate-800">{{ $header }}</h1>
                    @endisset
                </header>

                {{-- Page Content --}}
                <main class="flex-1 p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>

        {{-- Toast Notifications --}}
        <x-toast />
    </body>
</html>
