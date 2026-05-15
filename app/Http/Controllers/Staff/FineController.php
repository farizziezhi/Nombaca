<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Fine;

class FineController extends Controller
{
    /**
     * Tampilkan seluruh data denda.
     *
     * Optimasi HDD:
     * - Eager Loading with(['borrowing.user', 'borrowing.book']) untuk mencegah N+1 di Blade.
     * - Statistik agregat dihitung lewat COUNT/SUM terpisah agar tidak terpengaruh pagination.
     */
    public function index()
    {
        $stats = [
            'unpaid'      => Fine::where('status', 'unpaid')->count(),
            'paid'        => Fine::where('status', 'paid')->count(),
            'totalUnpaid' => Fine::where('status', 'unpaid')->sum('amount'),
        ];

        $fines = Fine::with(['borrowing.user', 'borrowing.book'])
            ->orderByRaw("FIELD(status, 'unpaid', 'paid')")
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('staff.fines.index', compact('fines', 'stats'));
    }

    /**
     * Lunasi denda — ubah status menjadi 'paid'.
     */
    public function pay(Fine $fine)
    {
        if ($fine->status === 'paid') {
            return redirect()->back()->with('error', 'Denda ini sudah dilunasi sebelumnya.');
        }

        $fine->update(['status' => 'paid']);

        return redirect()->back()->with('success', 'Denda berhasil dilunasi!');
    }
}
