@extends('admin.layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-stone-500 hover:text-[#0D9488] transition">&larr; Kembali</a>
</div>

<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
            <h3 class="font-semibold text-lg mb-4">Informasi Pesanan</h3>
            <div class="space-y-2">
                <p><strong>Kode Pesanan:</strong> {{ $order->order_code }}</p>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                <p><strong>Metode Pembayaran:</strong>
                    @switch($order->payment_method)
                        @case('transfer_bca') Transfer BCA @break
                        @case('transfer_mandiri') Transfer Mandiri @break
                        @case('transfer_bri') Transfer BRI @break
                        @case('cod') COD (Bayar di Tempat) @break
                    @endswitch
                </p>
                @if($order->notes)
                    <p><strong>Catatan:</strong> {{ $order->notes }}</p>
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
                        <th class="px-4 py-3 text-right text-sm font-semibold text-stone-600">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-4 py-3">{{ $item->product->name }}</td>
                            <td class="px-4 py-3 text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-stone-50">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-bold">Total</td>
                        <td class="px-4 py-3 text-right font-bold" style="color: #0D9488;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
            <h3 class="font-semibold text-lg mb-4">Info Customer</h3>
            <div class="space-y-2">
                <p><strong>Nama:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Telepon:</strong> {{ $order->user->phone ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="font-semibold text-lg mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none mb-4">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="w-full bg-[#0D9488] text-white py-2 rounded-lg hover:bg-[#0f766e] transition">
                    Update Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
