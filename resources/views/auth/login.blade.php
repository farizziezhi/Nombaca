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
        <div x-data="{ show: false }">
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
            
            <div class="relative flex items-center">
                <input id="password" 
                    :type="show ? 'text' : 'password'" 
                    name="password" 
                    required 
                    autocomplete="current-password"

                    class="block w-full rounded-xl border-slate-200 pl-12 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-shadow"">
                
                <button type="button" 
                        @click="show = !show"
                        class="absolute left-0 inset-y-0 flex items-center justify-center w-12 text-slate-400 hover:text-emerald-600 transition-colors focus:outline-none">
                    
                    <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
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
