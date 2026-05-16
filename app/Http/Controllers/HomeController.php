<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama toko dengan daftar buku dan filter pencarian/kategori.
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $books = Book::with('category')
            ->when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%")
                ->orWhere('author', 'like', "%{$request->search}%")
                ->orWhere('publisher', 'like', "%{$request->search}%"))
            ->when($request->category, fn ($q) => $q->where('category_id', $request->category))
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('home', compact('books', 'categories'));
    }

    /**
     * Tampilkan halaman detail buku beserta buku lain dalam kategori yang sama.
     */
    public function show(Book $book)
    {
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        return view('books.show', compact('book', 'relatedBooks'));
    }

    /**
     * Tampilkan halaman About Us berisi profil toko buku.
     */
    public function about()
    {
        return view('about');
    }
}
