<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'NOMBACA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-white">
        <div class="min-h-screen flex flex-col lg:flex-row">
            {{-- Left Side: Branding (Deep Navy) --}}
            <div class="lg:w-5/12 xl:w-1/2 bg-slate-950 flex flex-col justify-between p-8 sm:p-12 lg:p-16 xl:p-20 relative overflow-hidden">
                <div class="relative z-10">
                    <a href="/" class="flex items-center gap-2 group inline-flex">
                        <svg class="h-8 w-8 text-emerald-400 group-hover:text-emerald-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="text-2xl font-bold text-white tracking-tight">NOMBACA</span>
                    </a>
                </div>
                
                <div class="relative z-10 mt-16 lg:mt-0">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight tracking-tight mb-6">
                        Pintu Gerbang <br/><span class="text-emerald-400">Pengetahuan</span> Anda.
                    </h1>
                    <p class="text-lg text-slate-400 max-w-md leading-relaxed">
                        Akses ribuan koleksi literatur fisik dan digital. Mari jadikan membaca sebagai gaya hidup, bukan sekadar kewajiban.
                    </p>
                </div>

                <div class="relative z-10 mt-16 lg:mt-0 hidden lg:block">
                    <p class="text-sm text-slate-500 font-medium tracking-wide">
                        &copy; {{ date('Y') }} Sistem Manajemen Perpustakaan Digital.
                    </p>
                </div>

                {{-- Decorative background elements (subtle) --}}
                <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-emerald-900/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute top-1/4 -right-20 w-72 h-72 bg-blue-900/20 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            {{-- Right Side: Form --}}
            <div class="lg:w-7/12 xl:w-1/2 flex flex-col justify-center px-8 sm:px-12 lg:px-24 py-12 bg-white">
                <div class="w-full max-w-md mx-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
