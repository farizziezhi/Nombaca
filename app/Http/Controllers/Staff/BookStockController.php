<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookStockController extends Controller
{
    /**
     * Menampilkan daftar buku untuk penyesuaian stok.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $books = Book::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->orderBy('title')
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('staff.inventory.index', compact('books', 'search'));
    }

    /**
     * Memperbarui stok buku spesifik.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $book->update(['stock' => $validated['stock']]);

        return redirect()->back()->with('success', "Stok buku '{$book->title}' berhasil diperbarui menjadi {$validated['stock']}.");
    }
}
