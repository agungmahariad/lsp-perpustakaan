<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Tampilkan halaman formulir kontak untuk mengirim pesan ke admin.
     */
    public function create()
    {
        return view('contact');
    }

    /**
     * Simpan pesan kontak dari user/guest ke database dan kirim ke admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Pesan Anda berhasil dikirim. Admin akan segera merespons.');
    }
}
