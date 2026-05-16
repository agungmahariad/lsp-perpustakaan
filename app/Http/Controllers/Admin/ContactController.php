<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Tampilkan semua pesan masuk dari user, urutkan pesan belum dibaca terlebih dahulu.
     */
    public function index()
    {
        $contacts = Contact::with('user')
            ->orderBy('is_read')
            ->latest()
            ->paginate(15);

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Tampilkan detail pesan kontak dan tandai sebagai sudah dibaca.
     */
    public function show(Contact $contact)
    {
        $contact->update(['is_read' => true]);

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Hapus pesan kontak dari database.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
