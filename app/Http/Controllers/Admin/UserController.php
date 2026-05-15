<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user selain admin yang sedang login.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $users = User::query()
            ->where('id', '!=', auth()->id())
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Perbarui role pengguna.
     *
     * Aturan keamanan:
     * - Tidak boleh mengubah role diri sendiri.
     * - Tidak boleh menurunkan role admin terakhir di sistem (mencegah perpustakaan kehilangan akses admin).
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'in:user,petugas,admin'],
        ]);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah role Anda sendiri.');
        }

        // Proteksi admin terakhir: cegah demote bila admin tinggal satu di sistem.
        if ($user->role === 'admin' && $validated['role'] !== 'admin') {
            $totalAdmin = User::where('role', 'admin')->count();

            if ($totalAdmin <= 1) {
                return redirect()->back()->with('error', 'Tidak dapat menurunkan role admin terakhir. Tunjuk admin lain terlebih dahulu.');
            }
        }

        $user->update(['role' => $validated['role']]);

        return redirect()->back()->with('success', "Role pengguna {$user->name} berhasil diperbarui menjadi {$validated['role']}.");
    }
}
