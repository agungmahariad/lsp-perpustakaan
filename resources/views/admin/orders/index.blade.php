@extends('layouts.admin')
@section('title', 'Manajemen Pesanan')
@section('content')
<div class="py-6">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-2 mb-6 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. pesanan atau nama user..."
            class="flex-1 min-w-48 px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent">
        <select name="status" class="px-3 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-transparent">
            <option value="">Semua Status</option>
            @foreach(['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Dibatalkan'] as $val => $label)
                <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-700 text-white text-sm px-4 py-2.5 rounded-xl hover:bg-gray-800 transition">Filter</button>
        @if(request()->anyFilled(['search','status']))
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-100 text-gray-600 text-sm px-4 py-2.5 rounded-xl hover:bg-gray-200 transition">Reset</a>
        @endif
    </form>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                <tr>
                    <th class="px-6 py-3 text-left">No. Pesanan</th>
                    <th class="px-6 py-3 text-left">Pelanggan</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Pembayaran</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                @php
                    $sc=['pending'=>'bg-yellow-100 text-yellow-700','processing'=>'bg-blue-100 text-blue-700','shipped'=>'bg-indigo-100 text-indigo-700','delivered'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700'];
                    $sl=['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Selesai','cancelled'=>'Batal'];
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 font-medium text-gray-800">{{ $order->order_number }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ $order->user->name }}</td>
                    <td class="px-6 py-3 font-semibold text-indigo-700">{{ $order->formatted_total }}</td>
                    <td class="px-6 py-3"><span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $sc[$order->status] }}">{{ $sl[$order->status] }}</span></td>
                    <td class="px-6 py-3 text-green-600 text-xs font-medium">COD</td>
                    <td class="px-6 py-3 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-3 text-center">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-800 text-xs font-medium">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-10 text-center text-gray-400">Tidak ada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
@endsection
