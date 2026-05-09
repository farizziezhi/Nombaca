<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    Kelola User
                </h2>
                <p class="text-sm text-slate-500 mt-1">Manajemen hak akses dan role pengguna sistem.</p>
            </div>
            
            {{-- Search Bar --}}
            <form method="GET" action="{{ route('admin.users.index') }}" class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email..." 
                       class="w-full rounded-xl border-slate-200 bg-white py-2 pl-10 pr-4 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200">
                
                @if($users->isEmpty())
                    <div class="p-12 text-center">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 mb-4">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">Tidak ada data</h3>
                        <p class="text-slate-500">
                            @if($search)
                                Tidak menemukan user dengan kata kunci "{{ $search }}".
                            @else
                                Belum ada data user di sistem.
                            @endif
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-semibold">Pengguna</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Role Saat Ini</th>
                                    <th scope="col" class="px-6 py-4 font-semibold text-right">Ubah Role</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($users as $user)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="h-10 w-10 shrink-0 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-slate-900">{{ $user->name }}</div>
                                                    <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($user->role === 'admin')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-600/20">
                                                    <div class="h-1.5 w-1.5 rounded-full bg-purple-500"></div>
                                                    Admin
                                                </span>
                                            @elseif($user->role === 'petugas')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                                    <div class="h-1.5 w-1.5 rounded-full bg-blue-500"></div>
                                                    Petugas
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                                    <div class="h-1.5 w-1.5 rounded-full bg-slate-400"></div>
                                                    User
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="inline-flex items-center gap-2" x-data="{ submitting: false }" @submit="submitting = true">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <select name="role" class="rounded-lg border-slate-200 text-sm py-1.5 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                    <option value="petugas" {{ $user->role === 'petugas' ? 'selected' : '' }}>Petugas</option>
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                                
                                                <button type="submit" :disabled="submitting" class="rounded-lg bg-slate-900 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 disabled:opacity-50 transition">
                                                    <span x-show="!submitting">Simpan</span>
                                                    <span x-show="submitting" x-cloak>...</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($users->hasPages())
                        <div class="border-t border-slate-200 px-6 py-4">
                            {{ $users->links() }}
                        </div>
                    @endif
                @endif
                
            </div>
        </div>
    </div>
</x-admin-layout>
