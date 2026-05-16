@extends('layouts.admin')
@section('title', 'Pesan Masuk')
@section('content')
<div class="py-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                <tr>
                    <th class="px-6 py-3 text-left">Pengirim</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Subjek</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Waktu</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($contacts as $contact)
                <tr class="hover:bg-gray-50 {{ !$contact->is_read ? 'bg-indigo-50/30' : '' }}">
                    <td class="px-6 py-3">
                        <p class="font-{{ !$contact->is_read ? 'bold' : 'medium' }} text-gray-800">{{ $contact->name }}</p>
                    </td>
                    <td class="px-6 py-3 text-gray-600">{{ $contact->email }}</td>
                    <td class="px-6 py-3">
                        <p class="font-{{ !$contact->is_read ? 'semibold' : 'normal' }} text-gray-800 max-w-xs truncate">{{ $contact->subject }}</p>
                    </td>
                    <td class="px-6 py-3">
                        @if(!$contact->is_read)
                            <span class="bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">Belum Dibaca</span>
                        @else
                            <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Sudah Dibaca</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-gray-500 text-xs">{{ $contact->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-3">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.contacts.show', $contact->id) }}" class="text-indigo-600 hover:text-indigo-800 text-xs font-medium">Baca</a>
                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">Tidak ada pesan masuk</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($contacts->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $contacts->links() }}</div>
        @endif
    </div>
</div>
@endsection
