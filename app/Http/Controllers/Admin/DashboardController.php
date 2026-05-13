<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Statistik utama
        $stats = [
            'total_books'    => Book::count(),
            'total_members'  => User::where('role', 'user')->count(),
            'active_borrows' => Borrowing::whereIn('status', ['active', 'overdue'])->count(),
            'overdue'        => Borrowing::where('status', 'overdue')->count(),
            'pending'        => Borrowing::where('status', 'pending')->count(),
            'fines_unpaid'   => Fine::where('status', 'unpaid')->sum('amount'),
            'fines_collected'=> Fine::where('status', 'paid')->sum('amount'),
            'low_stock'      => Book::where('stock', '<=', 2)->count(),
        ];

        // 5 transaksi terbaru
        $recentBorrowings = Borrowing::with(['user', 'book'])
            ->latest()
            ->limit(5)
            ->get();

        // 5 buku stok menipis
        $lowStockBooks = Book::with('category')
            ->where('stock', '<=', 2)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        // Member paling aktif (top 5)
        $topMembers = User::where('role', 'user')
            ->withCount(['borrowings as total_borrows'])
            ->orderByDesc('total_borrows')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBorrowings', 'lowStockBooks', 'topMembers'));
    }
}
