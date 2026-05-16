@extends('layouts.store')

@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Pesanan Saya</h1>

    @if($orders->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <svg class="w-20 h-20 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-gray-500 mb-4">Belum ada pesanan</p>
            <a href="{{ route('home') }}" class="inline-block bg-indigo-600 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition">Mulai Belanja</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'processing' => 'bg-blue-100 text-blue-800',
                        'shipped' => 'bg-indigo-100 text-indigo-800',
                        'delivered' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'delivered' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ];
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="font-bold text-gray-800">{{ $order->order_number }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] }}">
                            {{ $statusLabels[$order->status] }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2 mb-4 flex-wrap">
                        @foreach($order->orderItems->take(3) as $item)
                            <div class="w-12 h-16 bg-indigo-50 rounded overflow-hidden">
                                @if($item->book->cover_image)
                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-300" fill="currentColor" viewBox="0 0 24 24"><path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        @if($order->orderItems->count() > 3)
                            <div class="w-12 h-16 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-500 font-medium">
                                +{{ $order->orderItems->count() - 3 }}
                            </div>
                        @endif
                        <div class="ml-2">
                            <p class="text-sm text-gray-600">{{ $order->orderItems->count() }} buku</p>
                            <p class="text-sm font-bold text-indigo-700">{{ $order->formatted_total }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                        <span class="text-xs text-green-600 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Bayar di Tempat
                        </span>
                        <a href="{{ route('orders.show', $order->id) }}" class="text-sm text-indigo-600 font-medium hover:underline">Lihat Detail</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
