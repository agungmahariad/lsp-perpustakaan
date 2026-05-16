@extends('layouts.admin')
@section('title', $book->title)
@section('content')
<div class="py-6 max-w-3xl">
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.books.edit', $book->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Edit Buku</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="md:flex">
            <div class="md:w-52 flex-shrink-0 bg-gradient-to-br from-indigo-50 to-purple-50 p-6 flex items-center justify-center">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="max-h-64 rounded shadow object-contain">
                @else
                    <div class="w-32 h-44 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-12 h-12 text-indigo-400" fill="currentColor" viewBox="0 0 24 24"><path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2z"/></svg>
                    </div>
                @endif
            </div>
            <div class="p-6 flex-1">
                <span class="bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $book->category->name }}</span>
                <h1 class="text-2xl font-bold text-gray-900 mt-3 mb-1">{{ $book->title }}</h1>
                <p class="text-gray-500 mb-5">oleh <span class="font-medium">{{ $book->author }}</span></p>
                <div class="grid grid-cols-2 gap-3 text-sm mb-5">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-400 mb-0.5">Penerbit</p>
                        <p class="font-medium text-gray-800">{{ $book->publisher }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-400 mb-0.5">Tahun Terbit</p>
                        <p class="font-medium text-gray-800">{{ $book->year }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-400 mb-0.5">Harga</p>
                        <p class="font-bold text-indigo-700">{{ $book->formatted_price }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-400 mb-0.5">Stok</p>
                        <p class="font-medium {{ $book->stock <= 5 ? 'text-red-600' : 'text-gray-800' }}">{{ $book->stock }} unit</p>
                    </div>
                    @if($book->isbn)
                    <div class="col-span-2 bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-400 mb-0.5">ISBN</p>
                        <p class="font-medium text-gray-800 font-mono text-xs">{{ $book->isbn }}</p>
                    </div>
                    @endif
                </div>
                @if($book->description)
                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-xs text-gray-400 mb-2">Deskripsi</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $book->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
