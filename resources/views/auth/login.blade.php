<x-guest-layout>
    <x-slot name="title">Masuk ke Akun Anda</x-slot>

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Selamat Datang Kembali</h2>
        <p class="text-sm text-slate-500 mt-2">Silakan masukkan kredensial Anda untuk melanjutkan.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{ submitting: false }" @submit="submitting = true" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                   class="block w-full rounded-xl border-slate-200 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-shadow">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                   class="block w-full rounded-xl border-slate-200 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-shadow">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500 w-4 h-4">
                <span class="text-sm font-medium text-slate-600 select-none">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-emerald-600 hover:text-emerald-500 transition-colors" href="{{ route('password.request') }}">
                    Lupa sandi?
                </a>
            @endif
        </div>

        <button type="submit" x-bind:disabled="submitting"
                class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all disabled:opacity-70 disabled:cursor-not-allowed">
            <span x-show="!submitting">Masuk ke Sistem</span>
            <span x-show="submitting" x-cloak class="flex items-center gap-2">
                <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Memproses...
            </span>
        </button>

        <p class="text-center text-sm font-medium text-slate-600 mt-6">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-500 font-bold transition-colors">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>
