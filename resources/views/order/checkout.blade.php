@extends('layouts.store')

@section('title', 'Checkout')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Checkout</h1>
    <div class="grid lg:grid-cols-5 gap-8">
        {{-- Form Alamat --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-bold text-gray-800 mb-5">Informasi Pengiriman</h2>
                <form action="{{ route('orders.store') }}" method="POST" id="checkoutForm" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Pengiriman <span class="text-red-500">*</span></label>
                        <textarea name="shipping_address" rows="3" required placeholder="Alamat lengkap termasuk RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, dan Kode Pos"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent text-sm resize-none @error('shipping_address') border-red-400 @enderror">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                        @error('shipping_address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent text-sm @error('phone') border-red-400 @enderror">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan (opsional)</label>
                        <textarea name="notes" rows="2" placeholder="Catatan tambahan untuk pesanan ini..."
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent text-sm resize-none">{{ old('notes') }}</textarea>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-green-800">Pembayaran di Tempat (COD)</p>
                            <p class="text-xs text-green-600 mt-0.5">Bayar saat buku diantarkan ke alamat Anda. Siapkan uang pas!</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Ringkasan Pesanan --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h2 class="font-bold text-gray-800 mb-4">Ringkasan ({{ $carts->count() }} item)</h2>
                <div class="space-y-3 mb-5 max-h-60 overflow-y-auto">
                    @foreach($carts as $item)
                        <div class="flex gap-3 py-2 border-b border-gray-50 last:border-0">
                            <div class="w-10 h-14 flex-shrink-0 bg-indigo-50 rounded overflow-hidden">
                                @if($item->book->cover_image)
                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-300" fill="currentColor" viewBox="0 0 24 24"><path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-800 line-clamp-2">{{ $item->book->title }}</p>
                                <p class="text-xs text-gray-500">x{{ $item->quantity }}</p>
                                <p class="text-xs font-semibold text-indigo-600">Rp {{ number_format($item->quantity * $item->book->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-100 pt-4 mb-5">
                    <div class="flex justify-between font-bold text-gray-800 text-base">
                        <span>Total Pembayaran</span>
                        <span class="text-indigo-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
                <button form="checkoutForm" type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl transition text-sm">
                    Buat Pesanan
                </button>
                <a href="{{ route('cart.index') }}" class="block w-full text-center text-gray-500 hover:text-indigo-600 text-sm mt-3 py-2 transition">
                    Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
