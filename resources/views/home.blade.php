@extends('layouts.store')

@section('title', 'Beranda')

@section('content')

{{-- Hero Section --}}
<section class="bg-gradient-to-br from-indigo-700 via-indigo-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 flex flex-col md:flex-row items-center gap-10">
        <div class="flex-1">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                Temukan Buku <br>Favoritmu di Sini
            </h1>
            <p class="text-indigo-100 text-lg mb-8">
                Koleksi ribuan buku berkualitas. Bayar saat buku tiba di tanganmu.
            </p>
            <form action="{{ route('home') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul, pengarang, atau penerbit..."
                    class="flex-1 px-5 py-3 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                <button type="submit" class="bg-yellow-400 text-gray-900 font-semibold px-6 py-3 rounded-xl hover:bg-yellow-300 transition whitespace-nowrap">
                    Cari Buku
                </button>
            </form>
        </div>
        <div class="hidden md:block flex-1 text-center">
            <svg class="w-56 h-56 mx-auto opacity-20" fill="white" viewBox="0 0 24 24">
                <path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2zm0 1.5v17h11v-17h-11zm2 2h7v1.5h-7V5.5zm0 3h7V10h-7V8.5z"/>
            </svg>
        </div>
    </div>
</section>

{{-- Filter Kategori --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 flex-wrap">
        <a href="{{ route('home') }}"
            class="px-4 py-2 rounded-full text-sm font-medium transition
                {{ ! request('category') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border border-gray-300 hover:border-indigo-400 hover:text-indigo-600' }}">
            Semua
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('home', array_merge(request()->except('page'), ['category' => $cat->id])) }}"
                class="px-4 py-2 rounded-full text-sm font-medium transition
                    {{ request('category') == $cat->id ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border border-gray-300 hover:border-indigo-400 hover:text-indigo-600' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>
</section>

{{-- Daftar Buku --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    {{-- Header hasil --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
            @if(request('search'))
                Hasil pencarian: "{{ request('search') }}"
            @else
                Koleksi Buku
            @endif
            <span class="text-sm font-normal text-gray-500 ml-2">({{ $books->total() }} buku)</span>
        </h2>
    </div>

    @if($books->isEmpty())
        <div class="text-center py-20">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-500 text-lg">Buku tidak ditemukan.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block text-indigo-600 hover:underline text-sm">Lihat semua buku</a>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5">
            @foreach($books as $book)
                <a href="{{ route('books.show', $book->slug) }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 overflow-hidden flex flex-col">
                    {{-- Cover --}}
                    <div class="aspect-[3/4] bg-gradient-to-br from-indigo-100 to-purple-100 overflow-hidden">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                alt="{{ $book->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-indigo-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2zm0 1.5v17h11v-17h-11zm2 2h7v1.5h-7V5.5zm0 3h7V10h-7V8.5z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div class="p-3 flex-1 flex flex-col">
                        <span class="text-xs text-indigo-500 font-medium mb-1">{{ $book->category->name }}</span>
                        <h3 class="text-xs font-semibold text-gray-800 line-clamp-2 mb-1 flex-1">{{ $book->title }}</h3>
                        <p class="text-xs text-gray-500 mb-2">{{ $book->author }}</p>
                        <p class="text-sm font-bold text-indigo-700">{{ $book->formatted_price }}</p>
                        @if($book->stock <= 5)
                            <span class="text-xs text-orange-500 mt-1">Sisa {{ $book->stock }}</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $books->links() }}
        </div>
    @endif
</section>

@endsection
