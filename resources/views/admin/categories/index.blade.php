@extends('layouts.admin')
@section('title', 'Kategori Buku')
@section('content')
<div class="py-6">
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.categories.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kategori
        </a>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Nama Kategori</th>
                    <th class="px-6 py-3 text-left">Slug</th>
                    <th class="px-6 py-3 text-left">Jumlah Buku</th>
                    <th class="px-6 py-3 text-left">Deskripsi</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $cat)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-gray-500">{{ $categories->firstItem() + $loop->index }}</td>
                    <td class="px-6 py-3 font-semibold text-gray-800">{{ $cat->name }}</td>
                    <td class="px-6 py-3 text-gray-500 font-mono text-xs">{{ $cat->slug }}</td>
                    <td class="px-6 py-3">
                        <span class="bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $cat->books_count }} buku</span>
                    </td>
                    <td class="px-6 py-3 text-gray-500 max-w-xs truncate">{{ $cat->description ?? '-' }}</td>
                    <td class="px-6 py-3">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.categories.edit', $cat->id) }}" class="text-indigo-600 hover:text-indigo-800 text-xs font-medium">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">Belum ada kategori</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $categories->links() }}</div>
        @endif
    </div>
</div>
@endsection
