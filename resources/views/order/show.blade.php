@extends('layouts.store')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-indigo-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan</h1>
    </div>

    @php
        $statusColors = ['pending'=>'bg-yellow-100 text-yellow-800','processing'=>'bg-blue-100 text-blue-800','shipped'=>'bg-indigo-100 text-indigo-800','delivered'=>'bg-green-100 text-green-800','cancelled'=>'bg-red-100 text-red-800'];
        $statusLabels = ['pending'=>'Menunggu Konfirmasi','processing'=>'Sedang Diproses','shipped'=>'Dalam Pengiriman','delivered'=>'Selesai Diterima','cancelled'=>'Dibatalkan'];
    @endphp

    {{-- Status --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 mb-1">Nomor Pesanan</p>
                <p class="font-bold text-gray-900 text-lg">{{ $order->order_number }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors[$order->status] }}">
                {{ $statusLabels[$order->status] }}
            </span>
        </div>
    </div>

    {{-- Item Pesanan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="font-bold text-gray-800 mb-4">Item Pesanan</h2>
        <div class="space-y-4">
            @foreach($order->orderItems as $item)
                <div class="flex gap-4 py-3 border-b border-gray-50 last:border-0">
                    <div class="w-14 h-20 flex-shrink-0 bg-indigo-50 rounded-lg overflow-hidden">
                        @if($item->book->cover_image)
                            <img src="{{ asset('storage/' . $item->book->cover_image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center"><svg class="w-6 h-6 text-indigo-300" fill="currentColor" viewBox="0 0 24 24"><path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2z"/></svg></div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800">{{ $item->book->title }}</p>
                        <p class="text-sm text-gray-500">{{ $item->book->author }}</p>
                        <p class="text-sm text-gray-500 mt-1">Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-indigo-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex justify-between font-bold text-gray-800 pt-4 border-t border-gray-100 mt-2 text-base">
            <span>Total Pembayaran</span>
            <span class="text-indigo-700 text-lg">{{ $order->formatted_total }}</span>
        </div>
    </div>

    {{-- Info Pengiriman --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-bold text-gray-800 mb-4">Informasi Pengiriman</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400 text-xs mb-1">Penerima</p>
                <p class="font-medium text-gray-800">{{ $order->user->name }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-1">Telepon</p>
                <p class="font-medium text-gray-800">{{ $order->phone }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-400 text-xs mb-1">Alamat Pengiriman</p>
                <p class="font-medium text-gray-800">{{ $order->shipping_address }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-1">Metode Pembayaran</p>
                <p class="font-medium text-green-600">Bayar di Tempat (COD)</p>
            </div>
            @if($order->notes)
            <div class="col-span-2">
                <p class="text-gray-400 text-xs mb-1">Catatan</p>
                <p class="font-medium text-gray-800">{{ $order->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
