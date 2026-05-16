<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Tampilkan semua pesanan dari seluruh user dengan filter status.
     */
    public function index(Request $request)
    {
        $orders = Order::with('user')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where('order_number', 'like', "%{$request->search}%")
                ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$request->search}%")))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail pesanan beserta item-item yang dipesan.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.book']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan (misal: pending → processing → shipped → delivered).
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
