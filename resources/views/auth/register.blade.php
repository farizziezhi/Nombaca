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
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                   class="block w-full rounded-xl border-slate-200 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-shadow">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                   class="block w-full rounded-xl border-slate-200 px-4 py-3 text-slate-900 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition-shadow">
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
