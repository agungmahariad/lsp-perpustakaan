<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja milik user yang sedang login.
     */
    public function index()
    {
        $carts = Cart::with('book.category')
            ->where('user_id', auth()->id())
            ->get();

        $total = $carts->sum(fn ($item) => $item->quantity * $item->book->price);

        return view('cart.index', compact('carts', 'total'));
    }

    /**
     * Tambahkan buku ke keranjang; jika sudah ada, tambah kuantitasnya.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stock < $request->quantity) {
            return back()->with('error', 'Stok buku tidak mencukupi.');
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'book_id' => $request->book_id],
            ['quantity' => 0]
        );

        // Cek total quantity agar tidak melebihi stok
        $newQty = $cart->quantity + $request->quantity;
        if ($newQty > $book->stock) {
            return back()->with('error', 'Total kuantitas melebihi stok yang tersedia.');
        }

        $cart->update(['quantity' => $newQty]);

        return redirect()->route('cart.index')
            ->with('success', 'Buku berhasil ditambahkan ke keranjang.');
    }

    /**
     * Update kuantitas item di keranjang.
     */
    public function update(Request $request, Cart $cart)
    {
        $this->authorize('update', $cart);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($request->quantity > $cart->book->stock) {
            return back()->with('error', 'Kuantitas melebihi stok yang tersedia.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Hapus item dari keranjang belanja.
     */
    public function destroy(Cart $cart)
    {
        $this->authorize('delete', $cart);

        $cart->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
