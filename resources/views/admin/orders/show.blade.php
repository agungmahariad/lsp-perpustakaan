@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $order->order_number)
@section('content')
<div class="py-6 max-w-4xl">
    @php
        $sc=['pending'=>'bg-yellow-100 text-yellow-700','processing'=>'bg-blue-100 text-blue-700','shipped'=>'bg-indigo-100 text-indigo-700','delivered'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700'];
        $sl=['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Dibatalkan'];
    @endphp

    <div class="grid md:grid-cols-3 gap-6 mb-6">
        <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Nomor Pesanan</p>
                    <p class="font-bold text-gray-900 text-xl">{{ $order->order_number }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $sc[$order->status] }}">{{ $sl[$order->status] }}</span>
            </div>
            <h3 class="font-semibold text-gray-700 mb-3 text-sm">Item Pesanan</h3>
            <div class="space-y-3">
                @foreach($order->orderItems as $item)
                <div class="flex gap-3 py-2 border-b border-gray-50 last:border-0">
                    <div class="w-12 h-16 flex-shrink-0 bg-indigo-50 rounded overflow-hidden">
                        @if($item->book->cover_image)
                            <img src="{{ asset('storage/' . $item->book->cover_image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center"><svg class="w-5 h-5 text-indigo-300" fill="currentColor" viewBox="0 0 24 24"><path d="M6.5 2h11A1.5 1.5 0 0119 3.5v17a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 015 20.5v-17A1.5 1.5 0 016.5 2z"/></svg></div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 text-sm">{{ $item->book->title }}</p>
                        <p class="text-xs text-gray-500">{{ $item->book->author }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}</p>
                    </div>
                    <p class="font-bold text-indigo-700 text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
            <div class="flex justify-between font-bold text-gray-800 pt-4 border-t border-gray-100 mt-2">
                <span>Total Pembayaran</span>
                <span class="text-indigo-700 text-lg">{{ $order->formatted_total }}</span>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-semibold text-gray-700 mb-3 text-sm">Informasi Pelanggan</h3>
                <div class="space-y-2 text-sm">
                    <div><p class="text-xs text-gray-400">Nama</p><p class="font-medium text-gray-800">{{ $order->user->name }}</p></div>
                    <div><p class="text-xs text-gray-400">Email</p><p class="text-gray-600">{{ $order->user->email }}</p></div>
                    <div><p class="text-xs text-gray-400">Telepon</p><p class="text-gray-600">{{ $order->phone }}</p></div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-semibold text-gray-700 mb-3 text-sm">Alamat Pengiriman</h3>
                <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                @if($order->notes)
                    <div class="mt-3 pt-3 border-t border-gray-50">
                        <p class="text-xs text-gray-400 mb-1">Catatan</p>
                        <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-semibold text-gray-700 mb-3 text-sm">Update Status</h3>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-3">
                    @csrf @method('PATCH')
                    <select name="status" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent">
                        @foreach(['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Dibatalkan'] as $val => $label)
                            <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
