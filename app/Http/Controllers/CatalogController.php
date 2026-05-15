<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Tampilkan katalog buku publik.
     *
     * WAJIB Eager Loading with('category') — optimasi HDD.
     * Mendukung pencarian (title/author) dan filter (category_id).
     */
    public function index(Request $request): View
    {
        $query = Book::with('category');

        // Pencarian berdasarkan judul atau penulis
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($categoryId = $request->input('category')) {
            $query->where('category_id', $categoryId);
        }

        $books = $query->orderBy('title')->orderBy('id')->paginate(12)->appends($request->query());

        $categories = Category::orderBy('name')->get();

        return view('catalog.index', compact('books', 'categories'));
    }

    /**
     * Tampilkan detail buku secara lengkap.
     *
     * WAJIB menggunakan Route Model Binding dan Eager Loading.
     */
    public function show(string $isbn): View
    {
        $book = Book::with('category')->where('isbn', $isbn)->firstOrFail();
        return view('catalog.show', compact('book'));
    }
}
