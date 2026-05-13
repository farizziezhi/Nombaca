<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CirculationController extends Controller
{
    /**
     * Meja Sirkulasi — daftar seluruh transaksi peminjaman.
     * WAJIB Eager Loading with(['user', 'book', 'fine']) — optimasi HDD.
     */
    public function index(): View
    {
        $borrowings = Borrowing::with(['user', 'book', 'finePayment'])
            ->orderByRaw("FIELD(status, 'pending', 'active', 'overdue', 'returned')")
            ->latest()
            ->get();

        return view('staff.circulation.index', compact('borrowings'));
    }

    /**
     * Verifikasi Pengambilan — ubah status pending → active.
     * Stok TIDAK dikurangi di sini (sudah dipotong saat Member booking).
     */
    public function approve(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaksi ini tidak dalam status pending.');
        }

        $borrowing->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Buku telah diserahkan kepada Member.');
    }

    /**
     * Verifikasi Pengembalian — ubah status → returned, kembalikan stok.
     *
     * Pessimistic Locking & DB Transaction (WAJIB):
     * 1. Validasi status = active / overdue
     * 2. Update borrowing → returned + return_date
     * 3. lockForUpdate() buku, increment stok
     */
    public function returnBook(Borrowing $borrowing): RedirectResponse
    {
        if (! in_array($borrowing->status, ['active', 'overdue'])) {
            return redirect()->back()->with('error', 'Transaksi ini tidak bisa dikembalikan.');
        }

        DB::transaction(function () use ($borrowing) {
            // Hitung denda jika terlambat saat dikembalikan (agar tidak terlewat cron)
            $daysLate = max(0, $borrowing->due_date->startOfDay()->diffInDays(now()->startOfDay()));
            if ($daysLate > 0) {
                $totalFine = $daysLate * 1000;
                
                $existingFine = \App\Models\Fine::where('borrowing_id', $borrowing->id)->first();
                if ($existingFine) {
                    if ($existingFine->status !== 'paid') {
                        $existingFine->update(['amount' => $totalFine]);
                    }
                } else {
                    \App\Models\Fine::create([
                        'borrowing_id' => $borrowing->id,
                        'amount'       => $totalFine,
                        'status'       => 'unpaid',
                    ]);
                }
            }

            // Update status peminjaman
            $borrowing->update([
                'status'      => 'returned',
                'return_date' => now()->toDateString(),
            ]);

            // Kembalikan stok buku dengan pessimistic locking
            $book = Book::where('id', $borrowing->book_id)
                ->lockForUpdate()
                ->firstOrFail();

            $book->increment('stock');
        });

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan dan stok telah bertambah.');
    }

    /**
     * Batalkan peminjaman — hanya untuk status pending.
     * Stok dikembalikan karena sudah dipotong saat booking.
     */
    public function cancel(Borrowing $borrowing): RedirectResponse
    {
        if ($borrowing->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya peminjaman berstatus pending yang bisa dibatalkan.');
        }

        DB::transaction(function () use ($borrowing) {
            $borrowing->update(['status' => 'cancelled']);

            $book = Book::where('id', $borrowing->book_id)->lockForUpdate()->firstOrFail();
            $book->increment('stock');
        });

        return redirect()->back()->with('success', 'Peminjaman berhasil dibatalkan dan stok telah dikembalikan.');
    }
}
