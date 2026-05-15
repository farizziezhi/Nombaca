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
     *
     * Optimasi HDD:
     * - Eager Loading with(['book.category', 'finePayment']) untuk mencegah N+1.
     * - Statistik agregat dihitung lewat query COUNT/SUM agar pagination tidak mempengaruhi nilai ringkasan.
     */
    public function index(): View
    {
        $userId = Auth::id();

        $baseQuery = Borrowing::where('user_id', $userId);

        $stats = [
            'pending'     => (clone $baseQuery)->where('status', 'pending')->count(),
            'active'      => (clone $baseQuery)->where('status', 'active')->count(),
            'returned'    => (clone $baseQuery)->where('status', 'returned')->count(),
            'unpaidFines' => Fine::whereHas('borrowing', fn ($q) => $q->where('user_id', $userId))
                                 ->where('status', 'unpaid')
                                 ->sum('amount'),
        ];

        $borrowings = Borrowing::with(['book.category', 'finePayment'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('member.dashboard', compact('borrowings', 'stats'));
    }

    /**
     * Proses peminjaman buku oleh Member.
     *
     * Logika Krusial (semua dijalankan di dalam DB::transaction untuk mencegah race condition):
     * 1. Lock baris buku (lockForUpdate) — mencegah double-decrement stok.
     * 2. Cek blacklist denda (unpaid fines).
     * 3. Cek limit peminjaman aktif/pending (maks 3) — re-check di dalam transaksi.
     * 4. Cek member belum meminjam buku yang sama (status pending/active/overdue).
     * 5. Cek stok fisik > 0.
     * 6. Kurangi stok dan buat record Borrowing baru berstatus pending.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => ['required', 'integer', 'exists:books,id'],
        ]);

        $userId = Auth::id();
        $bookId = (int) $validated['book_id'];

        try {
            DB::transaction(function () use ($userId, $bookId) {
                // ─── 1. Pessimistic Lock pada baris buku ─────────────
                /** @var Book $book */
                $book = Book::where('id', $bookId)
                    ->lockForUpdate()
                    ->firstOrFail();

                // ─── 2. Cek Blacklist Denda ──────────────────────────
                $hasUnpaidFine = Fine::whereHas('borrowing', fn ($q) => $q->where('user_id', $userId))
                    ->where('status', 'unpaid')
                    ->exists();

                if ($hasUnpaidFine) {
                    throw new \RuntimeException('Gagal: Anda harus melunasi denda terlebih dahulu!');
                }

                // ─── 3. Cek Limit Peminjaman (maks 3) ───────────────
                $activeBorrowings = Borrowing::where('user_id', $userId)
                    ->whereIn('status', ['pending', 'active', 'overdue'])
                    ->count();

                if ($activeBorrowings >= 3) {
                    throw new \RuntimeException('Batas maksimal 3 buku!');
                }

                // ─── 4. Cek Duplikasi Buku ──────────────────────────
                $alreadyBorrowed = Borrowing::where('user_id', $userId)
                    ->where('book_id', $bookId)
                    ->whereIn('status', ['pending', 'active', 'overdue'])
                    ->exists();

                if ($alreadyBorrowed) {
                    throw new \RuntimeException('Anda sudah memiliki peminjaman aktif untuk buku ini.');
                }

                // ─── 5. Cek Stok Fisik ──────────────────────────────
                if ($book->stock < 1) {
                    throw new \RuntimeException('Stok habis!');
                }

                // ─── 6. Eksekusi: kurangi stok, buat peminjaman ─────
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
