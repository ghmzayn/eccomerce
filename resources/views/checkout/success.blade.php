@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Qios')

@section('content')
<div class="max-w-lg mx-auto px-4 py-16 text-center">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-2xl font-bold mb-2" style="color: #0D9488;">Pesanan Berhasil!</h1>
        <p class="text-stone-500 mb-6">Terima kasih, pesanan Anda telah diterima.</p>

        <div class="bg-stone-50 rounded-lg p-4 mb-6">
            <p class="text-sm text-stone-600 mb-1">Kode Pesanan</p>
            <p class="text-xl font-bold" style="color: #0D9488;">{{ $order->order_code }}</p>
        </div>

        <div class="text-left space-y-2 text-sm text-stone-600 mb-6">
            <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            <p><strong>Metode Pembayaran:</strong>
                @switch($order->payment_method)
                    @case('transfer_bca') Transfer BCA @break
                    @case('transfer_mandiri') Transfer Mandiri @break
                    @case('transfer_bri') Transfer BRI @break
                    @case('cod') COD (Bayar di Tempat) @break
                @endswitch
            </p>
            <p><strong>Status:</strong> Pending</p>
        </div>

        <div class="space-y-3">
            <a href="{{ route('orders.index') }}" class="block w-full bg-[#0D9488] text-white py-2 rounded-lg hover:bg-[#0f766e] transition font-medium">
                Lihat Pesanan Saya
            </a>
            <a href="{{ route('home') }}" class="block w-full border border-[#0D9488] text-[#0D9488] py-2 rounded-lg hover:bg-stone-50 transition font-medium">
                Kembali ke Home
            </a>
        </div>
    </div>
</div>
@endsection
