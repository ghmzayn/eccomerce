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
            <p class="text-stone-600"><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
            @if($order->shipping)
                <p class="text-stone-600"><strong>Kurir:</strong> {{ $order->shipping->courier }} - {{ $order->shipping->service }}</p>
                <p class="text-stone-600"><strong>Status:</strong>
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                        @switch($order->shipping->status)
                            @case('diproses') bg-yellow-100 text-yellow-700 @break
                            @case('dikirim') bg-blue-100 text-blue-700 @break
                            @case('sampai') bg-green-100 text-green-700 @break
                        @endswitch">
                        {{ $order->shipping->status }}
                    </span>
                </p>
                @if($order->shipping->tracking_number)
                    <p class="text-stone-600"><strong>Resi:</strong> {{ $order->shipping->tracking_number }}</p>
                @endif
            @endif
            <p class="text-stone-600 mt-1">
                <strong>Metode Pembayaran:</strong>
                @switch($order->payment_method)
                    @case('transfer_bca') Transfer BCA @break
                    @case('transfer_mandiri') Transfer Mandiri @break
                    @case('transfer_bri') Transfer BRI @break
                    @case('qris') QRIS @break
                    @case('cod') COD (Bayar di Tempat) @break
                @endswitch
            </p>
            @if($order->notes)
                <p class="text-stone-600 mt-1"><strong>Catatan:</strong> {{ $order->notes }}</p>
            @endif
        </div>

        @if($order->payment_method !== 'cod')
            <div class="border-t pt-4 mt-4">
                <h3 class="font-semibold mb-2">Pembayaran</h3>
                <p class="text-stone-600"><strong>Status:</strong>
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                        @switch($order->payment_status)
                            @case('pending') bg-yellow-100 text-yellow-700 @break
                            @case('paid') bg-green-100 text-green-700 @break
                            @case('failed') bg-red-100 text-red-700 @break
                        @endswitch">
                        @switch($order->payment_status)
                            @case('pending') Belum Dibayar @break
                            @case('paid') Lunas @break
                            @case('failed') Gagal @break
                        @endswitch
                    </span>
                </p>

                @if($order->payment_status === 'pending')
                    <div class="mt-3 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800 mb-3">
                            @switch($order->payment_method)
                                @case('transfer_bca') Transfer ke BCA: <strong>1234567890</strong> a.n. Qios Store @break
                                @case('transfer_mandiri') Transfer ke Mandiri: <strong>9876543210</strong> a.n. Qios Store @break
                                @case('transfer_bri') Transfer ke BRI: <strong>5556667777</strong> a.n. Qios Store @break
                                @case('qris') Scan QRIS berikut untuk pembayaran @break
                            @endswitch
                        </p>

                        @if(!$order->payment_proof)
                            <form action="{{ route('orders.payment-proof', $order) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label class="block text-sm font-medium text-yellow-800 mb-1">Upload Bukti Transfer</label>
                                <input type="file" name="payment_proof" accept="image/*" required
                                    class="w-full px-3 py-2 border border-yellow-300 rounded-lg text-sm bg-white focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                                @error('payment_proof')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <button type="submit" class="mt-3 bg-[#0D9488] text-white px-4 py-2 rounded-lg hover:bg-[#0f766e] transition text-sm font-medium">
                                    Upload Bukti
                                </button>
                            </form>
                        @else
                            <div class="mt-2">
                                <p class="text-sm text-green-700 font-medium mb-1">Bukti sudah diupload:</p>
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="inline-block">
                                    <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran" class="w-32 h-32 object-cover rounded border">
                                </a>
                                <p class="text-xs text-yellow-700 mt-1">Menunggu verifikasi admin.</p>
                            </div>
                        @endif
                    </div>
                @elseif($order->payment_status === 'paid')
                    <p class="text-sm text-green-600 mt-1">Lunas pada {{ $order->paid_at->format('d M Y H:i') }}</p>
                @endif
            </div>
        @endif
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
                    <td colspan="3" class="px-4 py-2 text-right text-sm">Subtotal</td>
                    <td class="px-4 py-2 text-center">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
                @if($order->shipping)
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-right text-sm">Ongkos Kirim</td>
                        <td class="px-4 py-2 text-center">Rp {{ number_format($order->shipping->shipping_cost, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" class="px-4 py-3 text-right font-bold">Total Pembayaran</td>
                    <td class="px-4 py-3 text-center font-bold" style="color: #0D9488;">
                        Rp {{ number_format($order->total_price + ($order->shipping->shipping_cost ?? 0), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection