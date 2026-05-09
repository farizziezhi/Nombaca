<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Fine;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman dasbor Laporan (Statistik dan tombol Export).
     */
    public function index()
    {
        // Statistik ringkasan
        $totalBorrowings = Borrowing::count();
        $totalActive = Borrowing::whereIn('status', ['active', 'overdue'])->count();
        $totalReturned = Borrowing::where('status', 'returned')->count();
        
        // Total denda terkumpul (sudah dibayar)
        $totalFinesCollected = Fine::where('status', 'paid')->sum('amount');
        
        // Total potensi denda (belum dibayar)
        $totalFinesPending = Fine::where('status', 'unpaid')->sum('amount');

        return view('admin.reports.index', compact(
            'totalBorrowings', 
            'totalActive', 
            'totalReturned', 
            'totalFinesCollected',
            'totalFinesPending'
        ));
    }

    /**
     * Tampilkan halaman preview PDF di dalam iframe.
     */
    public function preview()
    {
        return view('admin.reports.preview');
    }

    /**
     * Ekspor seluruh data sirkulasi ke PDF.
     */
    public function exportPdf(\Illuminate\Http\Request $request)
    {
        // Ambil data dengan Eager Loading
        $borrowings = Borrowing::with(['user', 'book', 'finePayment'])
            ->latest()
            ->get();

        // Hitung total denda yang berhasil ditagih
        $totalCollected = Fine::where('status', 'paid')->sum('amount');

        // Render PDF menggunakan view khusus
        $pdf = Pdf::loadView('admin.reports.pdf', compact('borrowings', 'totalCollected'));

        // Konfigurasi kertas A4 landscape untuk tabel yang lebar
        $pdf->setPaper('a4', 'landscape');

        // Unduh langsung atau stream berdasarkan parameter query
        if ($request->has('download')) {
            return $pdf->download('Laporan_Sirkulasi_NOMBACA.pdf');
        }

        // Stream PDF ke browser (untuk preview dalam iframe)
        return $pdf->stream('Laporan_Sirkulasi_NOMBACA.pdf');
    }
}
