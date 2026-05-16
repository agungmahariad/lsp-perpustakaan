@extends('layouts.store')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Keranjang Belanja</h1>

    @if($carts->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Keranjang Anda Kosong</h2>
            <p class="text-gray-500 mb-6">Yuk, temukan buku favoritmu!</p>
            <a href="{{ route('home') }}" class="inline-block bg-indigo-600 text-white font-semibold px-8 py-3 rounded-xl hover:bg-indigo-700 transition">Belanja Sekarang</a>
        </div>
    @else
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                @foreach($carts as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex gap-5">
                        <div class="w-20 h-28 flex-shrink-0 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg overflow-hidden">
                            @if($item->book->cover_image)
                                <img src="{{ asset('storage/' . $item->book->cover_image) }}" alt="{{ $item->book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-indigo-300" fill="currentColor" viewBox="0 0 24 24"><path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2zm0 1.5v17h11v-17h-11zm2 2h7v1.5h-7V5.5zm0 3h7V10h-7V8.5z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('books.show', $item->book->slug) }}" class="font-semibold text-gray-800 hover:text-indigo-600 line-clamp-2">{{ $item->book->title }}</a>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $item->book->author }}</p>
                            <p class="text-sm text-indigo-600 font-semibold mt-1">{{ $item->book->formatted_price }}</p>
                            <div class="flex items-center justify-between mt-3">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                    @csrf @method('PATCH')
                                    <button type="button" onclick="adjustQty(this,-1)" class="px-2.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold text-sm">-</button>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->book->stock }}"
                                        class="w-12 text-center py-1.5 text-sm border-none focus:outline-none font-medium"
                                        onchange="this.form.submit()">
                                    <button type="button" onclick="adjustQty(this,1)" class="px-2.5 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold text-sm">+</button>
                                </form>
                                <div class="flex items-center gap-4">
                                    <span class="font-bold text-gray-800">Rp {{ number_format($item->quantity * $item->book->price, 0, ',', '.') }}</span>
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition" onclick="return confirm('Hapus item ini?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h2 class="font-bold text-gray-800 text-lg mb-5">Ringkasan Pesanan</h2>
                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Total Item</span><span>{{ $carts->sum('quantity') }} buku</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Pembayaran</span><span class="text-green-600 font-medium">Bayar di Tempat</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 flex justify-between font-bold text-gray-800">
                            <span>Total</span>
                            <span class="text-indigo-700 text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('orders.checkout') }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition">Lanjut Checkout</a>
                    <a href="{{ route('home') }}" class="block w-full text-center text-gray-500 hover:text-indigo-600 text-sm mt-3 py-2 transition">Lanjut Belanja</a>
                </div>
            </div>
        </div>
    @endif
</div>
@push('scripts')
<script>
function adjustQty(btn, delta) {
    const input = btn.parentElement.querySelector('input[name="quantity"]');
    const max = parseInt(input.max);
    const newVal = parseInt(input.value) + delta;
    if (newVal >= 1 && newVal <= max) { input.value = newVal; input.form.submit(); }
}
</script>
@endpush
@endsection
