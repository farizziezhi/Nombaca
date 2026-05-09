<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    /**
     * Dashboard Member — riwayat peminjaman.
     * WAJIB Eager Loading with(['book', 'fine']) — optimasi HDD.
     */
    public function index(): View
    {
        $borrowings = Borrowing::with(['book.category', 'finePayment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('member.dashboard', compact('borrowings'));
    }

    /**
     * Proses peminjaman buku oleh Member.
     *
     * Logika Krusial:
     * 1. Cek blacklist denda (unpaid fines)
     * 2. Cek limit peminjaman (maks 3)
     * 3. Pessimistic Locking + DB Transaction
     * 4. Cek stok fisik
     * 5. Kurangi stok, buat record Borrowing
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'book_id' => ['required', 'exists:books,id'],
        ]);

        $userId = Auth::id();

        // ─── 1. Cek Blacklist Denda ────────────────────────
        $hasUnpaidFine = Fine::whereHas('borrowing', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'unpaid')->exists();

        if ($hasUnpaidFine) {
            return redirect()->back()->with('error', 'Gagal: Anda harus melunasi denda terlebih dahulu!');
        }

        // ─── 2. Cek Limit Peminjaman (maks 3) ─────────────
        $activeBorrowings = Borrowing::where('user_id', $userId)
            ->whereIn('status', ['pending', 'active'])
            ->count();

        if ($activeBorrowings >= 3) {
            return redirect()->back()->with('error', 'Batas maksimal 3 buku!');
        }

        // ─── 3. Pessimistic Locking & Transaksi ────────────
        try {
            DB::transaction(function () use ($request, $userId) {
                /** @var Book $book */
                $book = Book::where('id', $request->book_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // ─── 4. Cek Stok Fisik ─────────────────────
                if ($book->stock < 1) {
                    throw new \RuntimeException('Stok habis!');
                }

                // ─── 5. Eksekusi ───────────────────────────
                $book->decrement('stock');

                Borrowing::create([
                    'user_id'     => $userId,
                    'book_id'     => $book->id,
                    'borrow_date' => now()->toDateString(),
                    'due_date'    => now()->addDays(7)->toDateString(),
                    'status'      => 'pending',
                ]);
            });
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Buku berhasil dipesan! Silakan ambil di meja Petugas dalam 24 jam.');
    }
}
