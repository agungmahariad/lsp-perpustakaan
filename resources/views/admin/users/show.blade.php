@extends('layouts.admin')
@section('title', 'Detail User')
@section('content')
<div class="py-6 max-w-4xl">
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-2xl mb-3">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="font-bold text-gray-900 text-lg">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>
                @if($user->phone)
                    <p class="text-sm text-gray-500 mt-0.5">{{ $user->phone }}</p>
                @endif
                <span class="mt-3 bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full">User</span>
            </div>
            @if($user->address)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-400 mb-1">Alamat</p>
                <p class="text-sm text-gray-700">{{ $user->address }}</p>
            </div>
            @endif
            <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Bergabung sejak</p>
                <p class="text-sm font-medium text-gray-700">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="md:col-span-2">
            <h3 class="font-bold text-gray-800 mb-4">Riwayat Pesanan ({{ $user->orders->count() }})</h3>
            @if($user->orders->isEmpty())
                <div class="bg-white rounded-xl border border-gray-100 p-8 text-center text-gray-400">Belum ada pesanan</div>
            @else
                <div class="space-y-3">
                    @foreach($user->orders as $order)
                    @php
                        $sc=['pending'=>'bg-yellow-100 text-yellow-700','processing'=>'bg-blue-100 text-blue-700','shipped'=>'bg-indigo-100 text-indigo-700','delivered'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700'];
                        $sl=['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Dibatalkan'];
                    @endphp
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="font-bold text-gray-800 text-sm">{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $sc[$order->status] }}">{{ $sl[$order->status] }}</span>
                                <span class="font-bold text-indigo-700 text-sm">{{ $order->formatted_total }}</span>
                            </div>
                        </div>
                        <div class="flex gap-1.5">
                            @foreach($order->orderItems->take(4) as $item)
                                <div class="w-10 h-14 bg-indigo-50 rounded overflow-hidden flex-shrink-0">
                                    @if($item->book->cover_image)
                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center"><svg class="w-4 h-4 text-indigo-300" fill="currentColor" viewBox="0 0 24 24"><path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2z"/></svg></div>
                                    @endif
                                </div>
                            @endforeach
                            @if($order->orderItems->count() > 4)
                                <div class="w-10 h-14 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-500">+{{ $order->orderItems->count()-4 }}</div>
                            @endif
                        </div>
                        <div class="mt-3 flex justify-end">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 text-xs hover:underline">Lihat Detail</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
