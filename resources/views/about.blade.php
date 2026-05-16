@extends('layouts.store')

@section('title', 'Tentang Kami')

@section('content')
{{-- Hero --}}
<section class="bg-gradient-to-br from-indigo-700 to-purple-600 text-white py-20">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Tentang BookStore</h1>
        <p class="text-indigo-100 text-lg">Toko buku online terpercaya sejak 2020</p>
    </div>
</section>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    {{-- Misi & Visi --}}
    <div class="grid md:grid-cols-2 gap-10 mb-16">
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-3">Visi Kami</h2>
            <p class="text-gray-600 leading-relaxed">
                Menjadi platform toko buku online terbesar dan terpercaya di Indonesia, yang mendekatkan pembaca dengan ribuan judul buku berkualitas dari berbagai genre dan kategori.
            </p>
        </div>
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-3">Misi Kami</h2>
            <p class="text-gray-600 leading-relaxed">
                Menyediakan pengalaman belanja buku yang mudah, nyaman, dan terjangkau. Kami berkomitmen memberikan layanan terbaik dengan sistem pembayaran di tempat yang aman dan terpercaya.
            </p>
        </div>
    </div>

    {{-- Keunggulan --}}
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-10">Mengapa Memilih Kami?</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach([
                ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Koleksi Lengkap', 'desc' => 'Ribuan judul buku dari berbagai genre', 'color' => 'indigo'],
                ['icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'title' => 'Bayar di Tempat', 'desc' => 'Bayar saat buku tiba, tanpa khawatir', 'color' => 'green'],
                ['icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4', 'title' => 'Pengiriman Cepat', 'desc' => 'Dikirim ke seluruh Indonesia', 'color' => 'blue'],
                ['icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', 'title' => 'Dukungan 24/7', 'desc' => 'Tim kami siap membantu Anda', 'color' => 'purple'],
            ] as $item)
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-{{ $item['color'] }}-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-{{ $item['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">{{ $item['title'] }}</h3>
                <p class="text-sm text-gray-500">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Tim Kami --}}
    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-10 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Siap Memulai?</h2>
        <p class="text-gray-600 mb-6">Bergabunglah dengan ribuan pembaca yang telah mempercayai BookStore sebagai toko buku pilihan mereka.</p>
        <div class="flex gap-4 justify-center">
            <a href="{{ route('home') }}" class="bg-indigo-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-indigo-700 transition">Lihat Koleksi</a>
            <a href="{{ route('contact') }}" class="bg-white text-indigo-600 font-semibold px-6 py-3 rounded-xl border border-indigo-200 hover:bg-indigo-50 transition">Hubungi Kami</a>
        </div>
    </div>
</div>
@endsection
