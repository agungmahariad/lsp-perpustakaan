@extends('layouts.admin')
@section('title', 'Data Buku')
@section('content')
<div class="py-6">
    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <form action="{{ route('admin.books.index') }}" method="GET" class="flex gap-2 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau pengarang..."
                class="flex-1 px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent">
            <select name="category_id" class="px-3 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-700 text-white text-sm px-4 py-2.5 rounded-xl hover:bg-gray-800 transition">Filter</button>
            @if(request()->anyFilled(['search','category_id']))
                <a href="{{ route('admin.books.index') }}" class="bg-gray-100 text-gray-600 text-sm px-4 py-2.5 rounded-xl hover:bg-gray-200 transition">Reset</a>
            @endif
        </form>
        <a href="{{ route('admin.books.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition flex items-center gap-2 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Buku
        </a>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3 text-left">Cover</th>
                    <th class="px-4 py-3 text-left">Judul / Pengarang</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Harga</th>
                    <th class="px-4 py-3 text-left">Stok</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($books as $book)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="w-10 h-14 bg-indigo-50 rounded overflow-hidden">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-indigo-300" fill="currentColor" viewBox="0 0 24 24"><path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2z"/></svg>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <p class="font-semibold text-gray-800 max-w-xs truncate">{{ $book->title }}</p>
                        <p class="text-xs text-gray-500">{{ $book->author }} · {{ $book->year }}</p>
                    </td>
                    <td class="px-4 py-3"><span class="bg-indigo-100 text-indigo-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $book->category->name }}</span></td>
                    <td class="px-4 py-3 font-semibold text-indigo-700">{{ $book->formatted_price }}</td>
                    <td class="px-4 py-3">
                        <span class="text-sm font-medium {{ $book->stock <= 5 ? 'text-red-600' : 'text-gray-700' }}">{{ $book->stock }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="text-indigo-600 hover:text-indigo-800 text-xs font-medium">Edit</a>
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">Tidak ada buku ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($books->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $books->links() }}</div>
        @endif
    </div>
</div>
@endsection
