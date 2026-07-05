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
                        @case('qris') QRIS @break
                        @case('cod') COD (Bayar di Tempat) @break
                    @endswitch
                </p>
                <p><strong>Status Pembayaran:</strong>
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                        @switch($order->payment_status)
                            @case('pending') bg-yellow-100 text-yellow-700 @break
                            @case('paid') bg-green-100 text-green-700 @break
                            @case('failed') bg-red-100 text-red-700 @break
                        @endswitch">
                        {{ $order->payment_status }}
                    </span>
                </p>
                @if($order->shipping)
                    <p><strong>Kurir:</strong> {{ $order->shipping->courier }} - {{ $order->shipping->service }}</p>
                    <p><strong>Ongkos Kirim:</strong> Rp {{ number_format($order->shipping->shipping_cost, 0, ',', '.') }}</p>
                @endif
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
                        <td colspan="3" class="px-4 py-2 text-right text-sm">Subtotal</td>
                        <td class="px-4 py-2 text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @if($order->shipping)
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-right text-sm">Ongkos Kirim</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($order->shipping->shipping_cost, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right font-bold">Total Pembayaran</td>
                        <td class="px-4 py-3 text-right font-bold" style="color: #0D9488;">
                            Rp {{ number_format($order->total_price + ($order->shipping->shipping_cost ?? 0), 0, ',', '.') }}
                        </td>
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

        <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
            <h3 class="font-semibold text-lg mb-4">Pembayaran</h3>
            @if($order->payment_proof)
                <div class="mb-3">
                    <p class="text-sm font-medium text-stone-700 mb-1">Bukti Transfer:</p>
                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran" class="w-full h-32 object-cover rounded border">
                    </a>
                </div>
            @endif
            @if($order->paid_at)
                <p class="text-sm text-green-600 mb-3">Lunas pada {{ $order->paid_at->format('d M Y H:i') }}</p>
            @endif

            @if($order->payment_status === 'pending' && $order->payment_proof)
                <form action="{{ route('admin.orders.update-payment', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-2">
                        <button type="submit" name="payment_status" value="paid"
                            class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                            Konfirmasi Lunas
                        </button>
                        <button type="submit" name="payment_status" value="failed"
                            class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition text-sm"
                            onclick="return confirm('Tandai pembayaran gagal?')">
                            Tolak
                        </button>
                    </div>
                </form>
            @elseif($order->payment_status === 'pending' && !$order->payment_proof)
                <p class="text-sm text-stone-500">Belum ada bukti pembayaran.</p>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
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

        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="font-semibold text-lg mb-4">Pengiriman</h3>
            @if($order->shipping)
                <div class="space-y-2 mb-4 text-sm">
                    <p><strong>Kurir:</strong> {{ $order->shipping->courier }} - {{ $order->shipping->service }}</p>
                    <p><strong>Ongkir:</strong> Rp {{ number_format($order->shipping->shipping_cost, 0, ',', '.') }}</p>
                    <p><strong>Status:</strong>
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
                        <p><strong>Resi:</strong> {{ $order->shipping->tracking_number }}</p>
                    @endif
                </div>
                <form action="{{ route('admin.orders.update-shipping', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-stone-700 mb-1">Nomor Resi</label>
                        <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->shipping->tracking_number) }}"
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-stone-700 mb-1">Status Pengiriman</label>
                        <select name="shipping_status" required
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                            <option value="diproses" {{ $order->shipping->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="dikirim" {{ $order->shipping->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="sampai" {{ $order->shipping->status == 'sampai' ? 'selected' : '' }}>Sampai</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-[#0D9488] text-white py-2 rounded-lg hover:bg-[#0f766e] transition text-sm">
                        Update Pengiriman
                    </button>
                </form>
            @else
                <p class="text-stone-500 text-sm">Belum ada data pengiriman.</p>
            @endif
        </div>
    </div>
</div>
@endsection