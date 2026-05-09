<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Fine;

class FineController extends Controller
{
    /**
     * Tampilkan seluruh data denda.
     * Optimasi HDD: Eager Loading with('borrowing.user', 'borrowing.book')
     */
    public function index()
    {
        $fines = Fine::with(['borrowing.user', 'borrowing.book'])
            ->latest()
            ->get();

        return view('staff.fines.index', compact('fines'));
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
