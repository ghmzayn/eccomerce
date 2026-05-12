@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <p class="text-sm text-stone-500">Total Produk</p>
        <p class="text-3xl font-bold mt-1" style="color: #0D9488;">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <p class="text-sm text-stone-500">Total Kategori</p>
        <p class="text-3xl font-bold mt-1" style="color: #0D9488;">{{ $totalCategories }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <p class="text-sm text-stone-500">Total Pesanan</p>
        <p class="text-3xl font-bold mt-1" style="color: #0D9488;">{{ $totalOrders }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <p class="text-sm text-stone-500">Total Pendapatan</p>
        <p class="text-3xl font-bold mt-1" style="color: #0D9488;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border p-6">
    <h3 class="font-semibold text-lg mb-4">Pesanan Terbaru</h3>
    @if($recentOrders->count() > 0)
        <table class="w-full">
            <thead class="bg-stone-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-stone-600">Kode</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-stone-600">Customer</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-stone-600">Total</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-stone-600">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-stone-600">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($recentOrders as $order)
                    <tr>
                        <td class="px-4 py-2 font-medium">{{ $order->order_code }}</td>
                        <td class="px-4 py-2">{{ $order->user->name }}</td>
                        <td class="px-4 py-2 text-center">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 text-center">
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                                @switch($order->status)
                                    @case('pending') bg-yellow-100 text-yellow-700 @break
                                    @case('processing') bg-indigo-100 text-indigo-700 @break
                                    @case('shipped') bg-purple-100 text-purple-700 @break
                                    @case('completed') bg-green-100 text-green-700 @break
                                    @case('cancelled') bg-red-100 text-red-700 @break
                                @endswitch">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center text-sm">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-stone-500">Belum ada pesanan.</p>
    @endif
</div>
@endsection
