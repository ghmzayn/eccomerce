@extends('layouts.app')

@section('title', 'Checkout - Qios')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8" style="color: #0D9488;">Checkout</h1>

    <div class="grid md:grid-cols-5 gap-8">
        <div class="md:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h2 class="text-lg font-semibold mb-4">Detail Pengiriman</h2>

                <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                    @csrf

                    <div class="mb-4">
                        <label for="shipping_address" class="block text-sm font-medium text-stone-700 mb-1">Alamat Pengiriman</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('shipping_address') border-red-500 @enderror">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-stone-700 mb-2">Kurir Pengiriman</label>
                        @error('courier')
                            <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                        @enderror
                        <div class="space-y-2">
                            @foreach($couriers as $key => $opt)
                                <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-stone-50 courier-option" data-cost="{{ $opt['cost'] }}">
                                    <input type="radio" name="courier" value="{{ $key }}" {{ old('courier') == $key ? 'checked' : '' }} class="courier-radio" required>
                                    <span class="flex-1">{{ $opt['courier'] }} - {{ $opt['service'] }}</span>
                                    <span class="font-semibold text-stone-700">Rp {{ number_format($opt['cost'], 0, ',', '.') }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-stone-700 mb-2">Metode Pembayaran</label>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                        @enderror
                        <div class="space-y-2">
                            <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-stone-50">
                                <input type="radio" name="payment_method" value="transfer_bca" {{ old('payment_method') == 'transfer_bca' ? 'checked' : '' }} required>
                                <span>Transfer Bank BCA</span>
                            </label>
                            <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-stone-50">
                                <input type="radio" name="payment_method" value="transfer_mandiri" {{ old('payment_method') == 'transfer_mandiri' ? 'checked' : '' }}>
                                <span>Transfer Bank Mandiri</span>
                            </label>
                            <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-stone-50">
                                <input type="radio" name="payment_method" value="transfer_bri" {{ old('payment_method') == 'transfer_bri' ? 'checked' : '' }}>
                                <span>Transfer Bank BRI</span>
                            </label>
                            <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-stone-50">
                                <input type="radio" name="payment_method" value="qris" {{ old('payment_method') == 'qris' ? 'checked' : '' }}>
                                <span>QRIS</span>
                            </label>
                            <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-stone-50">
                                <input type="radio" name="payment_method" value="cod" {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
                                <span>COD (Bayar di Tempat)</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-stone-700 mb-1">Catatan (opsional)</label>
                        <textarea id="notes" name="notes" rows="2"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-[#0D9488] text-white py-3 rounded-lg hover:bg-[#0f766e] transition font-semibold">
                        Buat Pesanan
                    </button>
                </form>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h2 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h2>

                <div class="space-y-3 mb-4">
                    @foreach($cart as $item)
                        <div class="flex justify-between text-sm">
                            <span>{{ $item['nama_produk'] }} ({{ $item['nama_varian'] }}) x{{ $item['quantity'] }}</span>
                            <span>Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t pt-3 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Ongkos Kirim</span>
                        <span id="shipping-display">Rp 0</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total</span>
                        <span id="grand-total" style="color: #0D9488;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const subtotal = {{ $total }};
    const courierRadios = document.querySelectorAll('.courier-radio');
    const shippingDisplay = document.getElementById('shipping-display');
    const grandTotal = document.getElementById('grand-total');

    courierRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const label = this.closest('.courier-option');
            const cost = parseInt(label.dataset.cost);
            shippingDisplay.textContent = 'Rp ' + cost.toLocaleString('id-ID');
            grandTotal.textContent = 'Rp ' + (subtotal + cost).toLocaleString('id-ID');
        });
    });
</script>
@endpush
@endsection