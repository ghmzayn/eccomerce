@extends('admin.layouts.admin')

@section('title', 'Pesanan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="w-full">
        <thead class="bg-stone-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Kode</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Customer</th>
                <th class="px-4 py-3 text-right text-sm font-semibold text-stone-600">Total</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Status</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Tanggal</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($orders as $order)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $order->order_code }}</td>
                    <td class="px-4 py-3">{{ $order->user->name }}</td>
                    <td class="px-4 py-3 text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-center">
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
                    <td class="px-4 py-3 text-center text-sm">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-[#0D9488] hover:underline text-sm">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-stone-500">Belum ada pesanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>
@endsection
