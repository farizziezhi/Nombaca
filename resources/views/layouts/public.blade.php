<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="NOMBACA — Sistem Manajemen Perpustakaan Digital. Cari dan pinjam buku dengan mudah.">

        <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'NOMBACA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-50">

            {{-- ═══════════════════════════════════════════ --}}
            {{-- PUBLIC NAVBAR — Deep Navy                  --}}
            {{-- ═══════════════════════════════════════════ --}}
            <nav x-data="{ open: false }" class="bg-slate-800 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        {{-- Logo + Brand --}}
                        <div class="flex items-center gap-2">
                            <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                                <svg class="h-7 w-7 text-emerald-400 group-hover:text-emerald-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span class="text-lg font-bold text-white tracking-tight">NOMBACA</span>
                            </a>
                        </div>

                        {{-- Desktop Auth Links --}}
                        <div class="hidden sm:flex sm:items-center sm:gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}"
                                   class="rounded-lg px-3 py-2 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700 transition">
                                    Dashboard
                                </a>
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700 transition">
                                            <div class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </div>
                                            <span>{{ Auth::user()->name }}</span>
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">Profil Saya</x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                                Keluar
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @else
                                <a href="{{ route('login') }}"
                                   class="rounded-lg px-4 py-2 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700 transition">
                                    Masuk
                                </a>
                                <a href="{{ route('register') }}"
                                   class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 shadow-sm transition">
                                    Daftar Akun
                                </a>
                            @endauth
                        </div>

                        {{-- Mobile hamburger --}}
                        <div class="flex items-center sm:hidden">
                            <button @click="open = !open" class="rounded-md p-2 text-slate-400 hover:text-white hover:bg-slate-700 transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Mobile menu --}}
                <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-slate-700">
                    <div class="space-y-1 px-3 py-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700">Profil Saya</a>
                            <form method="POST" action="{{ route('logout') }}" x-data="{ submitting: false }" @submit="submitting = true">
                                @csrf
                                <button type="submit" x-bind:disabled="submitting" class="block w-full text-left rounded-md px-3 py-2 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700">
                                    <span x-show="!submitting">Keluar</span>
                                    <span x-show="submitting" x-cloak>Keluar...</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-700">Masuk</a>
                            <a href="{{ route('register') }}" class="block rounded-md px-3 py-2 text-sm font-semibold text-emerald-400 hover:text-emerald-300 hover:bg-slate-700">Daftar Akun</a>
                        @endauth
                    </div>
                </div>
            </nav>

            {{-- Page Content --}}
            <main>
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="border-t border-slate-200 bg-white">
                <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
                    <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                        <div class="flex items-center gap-2 text-slate-500">
                            <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-sm font-medium">NOMBACA</span>
                        </div>
                        <p class="text-xs text-slate-400">&copy; {{ date('Y') }} Sistem Manajemen Perpustakaan Digital.</p>
                    </div>
                </div>
            </footer>
        </div>

        {{-- Toast Notifications --}}
        <x-toast />
    </body>
</html>
