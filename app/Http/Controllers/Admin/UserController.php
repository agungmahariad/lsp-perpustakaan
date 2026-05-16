<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Tampilkan daftar semua user yang terdaftar (role = user).
     */
    public function index()
    {
        $users = User::where('role', 'user')
            ->withCount('orders')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Tampilkan detail user beserta riwayat pesanannya.
     */
    public function show(User $user)
    {
        $user->load(['orders.orderItems.book']);

        return view('admin.users.show', compact('user'));
    }
}
