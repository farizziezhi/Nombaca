<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     * WAJIB Eager Loading with('category') — optimasi HDD.
     */
    public function index(): View
    {
        $books = Book::with('category')->latest()->get();

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created book.
     * Validasi di-handle oleh StoreBookRequest (FormRequest).
     */
    public function store(StoreBookRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Book::create($data);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a book.
     */
    public function edit(Book $book): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book.
     * Validasi di-handle oleh UpdateBookRequest (FormRequest).
     */
    public function update(UpdateBookRequest $request, Book $book): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($data);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Remove the specified book.
     */
    public function destroy(Book $book): RedirectResponse
    {
        try {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $book->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('admin.books.index')
                ->with('error', 'Buku tidak bisa dihapus karena masih memiliki riwayat peminjaman.');
        }

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
