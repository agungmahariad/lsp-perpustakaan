@extends('layouts.store')

@section('title', $book->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-indigo-600">Beranda</a>
        <span>/</span>
        <a href="{{ route('home', ['category' => $book->category_id]) }}" class="hover:text-indigo-600">{{ $book->category->name }}</a>
        <span>/</span>
        <span class="text-gray-700 truncate max-w-xs">{{ $book->title }}</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="md:flex">
            {{-- Cover Image --}}
            <div class="md:w-72 lg:w-80 flex-shrink-0 bg-gradient-to-br from-indigo-50 to-purple-50 p-8 flex items-center justify-center">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                        alt="{{ $book->title }}"
                        class="max-h-80 w-full object-contain rounded-lg shadow">
                @else
                    <div class="w-40 h-56 bg-gradient-to-br from-indigo-200 to-purple-200 rounded-lg shadow flex items-center justify-center">
                        <svg class="w-16 h-16 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2zm0 1.5v17h11v-17h-11zm2 2h7v1.5h-7V5.5zm0 3h7V10h-7V8.5z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Detail Buku --}}
            <div class="flex-1 p-8">
                <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">
                    {{ $book->category->name }}
                </span>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                <p class="text-gray-500 mb-6">oleh <span class="text-gray-700 font-medium">{{ $book->author }}</span></p>

                {{-- Info Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 text-sm">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-400 text-xs mb-0.5">Penerbit</p>
                        <p class="font-medium text-gray-800">{{ $book->publisher }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-400 text-xs mb-0.5">Tahun Terbit</p>
                        <p class="font-medium text-gray-800">{{ $book->year }}</p>
                    </div>
                    @if($book->isbn)
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-400 text-xs mb-0.5">ISBN</p>
                        <p class="font-medium text-gray-800">{{ $book->isbn }}</p>
                    </div>
                    @endif
                </div>

                {{-- Harga & Stok --}}
                <div class="flex items-end gap-6 mb-6">
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Harga</p>
                        <p class="text-3xl font-bold text-indigo-700">{{ $book->formatted_price }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Stok</p>
                        @if($book->stock > 0)
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-sm font-semibold px-3 py-1 rounded-full">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                {{ $book->stock }} tersedia
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-sm font-semibold px-3 py-1 rounded-full">
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                Habis
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Add to Cart Form --}}
                @if($book->stock > 0)
                    @auth
                        <form action="{{ route('cart.store') }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                <button type="button" onclick="changeQty(-1)" class="px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold">-</button>
                                <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $book->stock }}"
                                    class="w-14 text-center py-2 border-none focus:outline-none text-sm font-medium">
                                <button type="button" onclick="changeQty(1)" class="px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold">+</button>
                            </div>
                            <button type="submit" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                            Login untuk Membeli
                        </a>
                    @endauth
                @endif

                {{-- Deskripsi --}}
                @if($book->description)
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h3 class="font-semibold text-gray-800 mb-3">Deskripsi Buku</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $book->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Buku Terkait --}}
    @if($relatedBooks->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Buku Terkait</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
                @foreach($relatedBooks as $related)
                    <a href="{{ route('books.show', $related->slug) }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 overflow-hidden">
                        <div class="aspect-[3/4] bg-gradient-to-br from-indigo-50 to-purple-50 overflow-hidden">
                            @if($related->cover_image)
                                <img src="{{ asset('storage/' . $related->cover_image) }}" alt="{{ $related->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-indigo-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2zm0 1.5v17h11v-17h-11zm2 2h7v1.5h-7V5.5zm0 3h7V10h-7V8.5z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <h4 class="text-xs font-semibold text-gray-800 line-clamp-2 mb-1">{{ $related->title }}</h4>
                            <p class="text-xs text-indigo-700 font-bold">{{ $related->formatted_price }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qty');
    const max = parseInt(input.max);
    const newVal = parseInt(input.value) + delta;
    if (newVal >= 1 && newVal <= max) input.value = newVal;
}
</script>
@endpush
@endsection
