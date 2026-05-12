@extends('layouts.app')

@section('title', 'Detail Pesanan - Qios')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-stone-500 hover:text-[#0D9488] transition">&larr; Kembali ke Pesanan</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h1 class="text-2xl font-bold" style="color: #0D9488;">{{ $order->order_code }}</h1>
                <p class="text-stone-500">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                @switch($order->status)
                    @case('pending') bg-yellow-100 text-yellow-700 @break
                    @case('processing') bg-indigo-100 text-indigo-700 @break
                    @case('shipped') bg-purple-100 text-purple-700 @break
                    @case('completed') bg-green-100 text-green-700 @break
                    @case('cancelled') bg-red-100 text-red-700 @break
                @endswitch">
                @switch($order->status)
                    @case('pending') Pending @break
                    @case('processing') Diproses @break
                    @case('shipped') Dikirim @break
                    @case('completed') Selesai @break
                    @case('cancelled') Dibatalkan @break
                @endswitch
            </span>
        </div>

        <div class="border-t pt-4">
            <h3 class="font-semibold mb-2">Detail Pengiriman</h3>
            <p class="text-stone-600">{{ $order->shipping_address }}</p>
            <p class="text-stone-600 mt-1">
                Metode Pembayaran:
                @switch($order->payment_method)
                    @case('transfer_bca') Transfer BCA @break
                    @case('transfer_mandiri') Transfer Mandiri @break
                    @case('transfer_bri') Transfer BRI @break
                    @case('cod') COD (Bayar di Tempat) @break
                @endswitch
            </p>
            @if($order->notes)
                <p class="text-stone-600 mt-1">Catatan: {{ $order->notes }}</p>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full">
            <thead class="bg-stone-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Produk</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Harga</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Jumlah</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($order->items as $item)
                    <tr>
                        <td class="px-4 py-4 font-medium">{{ $item->product->name }}</td>
                        <td class="px-4 py-4 text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-center">{{ $item->quantity }}</td>
                        <td class="px-4 py-4 text-center">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-stone-50">
                <tr>
                    <td colspan="3" class="px-4 py-3 text-right font-bold">Total</td>
                    <td class="px-4 py-3 text-center font-bold" style="color: #0D9488;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
