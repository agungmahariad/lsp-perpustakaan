<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin dengan ringkasan statistik:
     * jumlah buku, kategori, user, pesanan, dan pesan belum dibaca.
     */
    public function index()
    {
        $stats = [
            'total_books'      => Book::count(),
            'total_categories' => Category::count(),
            'total_users'      => User::where('role', 'user')->count(),
            'total_orders'     => Order::count(),
            'pending_orders'   => Order::where('status', 'pending')->count(),
            'unread_contacts'  => Contact::where('is_read', false)->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
