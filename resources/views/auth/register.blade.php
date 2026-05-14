<x-guest-layout>
    <x-slot name="title">Daftar Akun Baru</x-slot>

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Buat Akun Anda</h2>
        <p class="text-sm text-slate-500 mt-2">Daftar hari ini untuk mengakses koleksi buku tak terbatas.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ submitting: false }" @submit="submitting = true" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                   class="block w-full rounded-xl border-slate-200 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-shadow">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                   class="block w-full rounded-xl border-slate-200 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-shadow">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div x-data="{ show: false }">
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                       class="block w-full rounded-xl border-slate-200 px-4 py-3 pr-12 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-shadow">
                <button type="button" @click="show = !show"
                        class="absolute top-1/2 -translate-y-1/2 right-3 flex items-center justify-center w-7 h-7 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-slate-100 transition">
                    <svg x-show="!show" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="show" x-cloak class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div x-data="{ show: false }">
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Kata Sandi</label>
            <div class="relative">
                <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                       class="block w-full rounded-xl border-slate-200 px-4 py-3 pr-12 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-shadow">
                <button type="button" @click="show = !show"
                        class="absolute top-1/2 -translate-y-1/2 right-3 flex items-center justify-center w-7 h-7 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-slate-100 transition">
                    <svg x-show="!show" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="show" x-cloak class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
        </div>

        <div class="pt-2">
            <button type="submit" x-bind:disabled="submitting"
                    class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                <span x-show="!submitting">Daftar Akun</span>
                <span x-show="submitting" x-cloak class="flex items-center gap-2">
                    <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Memproses...
                </span>
            </button>
        </div>

        <p class="text-center text-sm font-medium text-slate-600 mt-6">
            Sudah mendaftar? 
            <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-500 font-bold transition-colors">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
