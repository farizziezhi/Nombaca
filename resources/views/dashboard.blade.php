<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(Auth::user()->role === 'user')
                {{-- Redirect member ke halaman peminjaman --}}
                <script>window.location.href = "{{ route('borrowings.index') }}";</script>
            @else
                {{-- Redirect admin/petugas ke admin dashboard --}}
                <script>window.location.href = "{{ route('admin.dashboard') }}";</script>
            @endif
        </div>
    </div>
</x-app-layout>
