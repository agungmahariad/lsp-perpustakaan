<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Tampilkan halaman form checkout dengan ringkasan item keranjang.
     */
    public function checkout()
    {
        $carts = Cart::with('book')
            ->where('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        $total = $carts->sum(fn ($item) => $item->quantity * $item->book->price);

        return view('order.checkout', compact('carts', 'total'));
    }

    /**
     * Proses checkout: buat pesanan, kurangi stok buku, dan kosongkan keranjang.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone'            => 'required|string|max:20',
            'notes'            => 'nullable|string',
        ]);

        $carts = Cart::with('book')
            ->where('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Validasi stok sebelum proses
        foreach ($carts as $cart) {
            if ($cart->book->stock < $cart->quantity) {
                return back()->with('error', "Stok buku '{$cart->book->title}' tidak mencukupi.");
            }
        }

        DB::transaction(function () use ($request, $carts) {
            $total = $carts->sum(fn ($item) => $item->quantity * $item->book->price);

            $order = Order::create([
                'order_number'     => Order::generateOrderNumber(),
                'user_id'          => auth()->id(),
                'total_price'      => $total,
                'status'           => 'pending',
                'payment_method'   => 'payment_at_delivery',
                'shipping_address' => $request->shipping_address,
                'phone'            => $request->phone,
                'notes'            => $request->notes,
            ]);

            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'  => $order->id,
                    'book_id'   => $cart->book_id,
                    'quantity'  => $cart->quantity,
                    'price'     => $cart->book->price,
                ]);

                // Kurangi stok buku setelah pesanan dibuat
                $cart->book->decrement('stock', $cart->quantity);
            }

            // Kosongkan keranjang user setelah checkout
            Cart::where('user_id', auth()->id())->delete();
        });

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibuat! Pembayaran dilakukan saat buku tiba.');
    }

    /**
     * Tampilkan riwayat pesanan milik user yang sedang login.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('orderItems.book')
            ->latest()
            ->paginate(10);

        return view('order.index', compact('orders'));
    }

    /**
     * Tampilkan detail pesanan tertentu milik user.
     */
    public function show(Order $order)
    {
        // Pastikan user hanya bisa melihat pesanannya sendiri
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load(['orderItems.book', 'user']);

        return view('order.show', compact('order'));
    }
}
