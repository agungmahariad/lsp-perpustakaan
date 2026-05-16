@extends('layouts.admin')
@section('title', 'Detail Pesan')
@section('content')
<div class="py-6 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="font-bold text-gray-900 text-lg mb-1">{{ $contact->subject }}</h2>
                <p class="text-xs text-gray-400">{{ $contact->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
            <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Sudah Dibaca</span>
        </div>
        <div class="bg-gray-50 rounded-xl p-4 mb-6">
            <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                <div><p class="text-xs text-gray-400 mb-0.5">Nama Pengirim</p><p class="font-medium text-gray-800">{{ $contact->name }}</p></div>
                <div><p class="text-xs text-gray-400 mb-0.5">Email</p><p class="font-medium text-gray-800">{{ $contact->email }}</p></div>
                @if($contact->user)
                <div class="col-span-2"><p class="text-xs text-gray-400 mb-0.5">Pengguna Terdaftar</p><p class="font-medium text-indigo-600">{{ $contact->user->name }}</p></div>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-2">Isi Pesan</p>
                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.contacts.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 rounded-xl transition text-sm">Kembali</a>
            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 font-semibold px-5 py-2.5 rounded-xl transition text-sm">Hapus Pesan</button>
            </form>
        </div>
    </div>
</div>
@endsection
