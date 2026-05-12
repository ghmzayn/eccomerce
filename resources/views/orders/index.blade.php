@extends('layouts.app')

@section('title', 'Pesanan Saya - Qios')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8" style="color: #0D9488;">Pesanan Saya</h1>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="block bg-white rounded-xl shadow-sm border hover:shadow-md transition p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-lg font-semibold">{{ $order->order_code }}</span>
                            <p class="text-sm text-stone-500 mt-1">{{ $order->created_at->format('d M Y H:i') }}</p>
                            <p class="font-semibold mt-2" style="color: #0D9488;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
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
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-stone-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <p class="text-lg text-stone-500 mb-4">Belum ada pesanan</p>
            <a href="{{ route('categories.index') }}" class="inline-block bg-[#0D9488] text-white px-6 py-2 rounded-lg hover:bg-[#0f766e] transition">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection
