@extends('layouts.app')

@section('title', 'Cara Pembelian - Qios')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-center mb-8" style="color: #0D9488;">Cara Pembelian</h1>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
            <div class="flex items-start space-x-4">
                <span class="bg-[#0D9488] text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shrink-0">1</span>
                <div>
                    <h3 class="font-semibold text-lg">Pilih Produk</h3>
                    <p class="text-stone-600 mt-1">Jelajahi berbagai kategori produk yang tersedia dan pilih yang Anda inginkan.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
            <div class="flex items-start space-x-4">
                <span class="bg-[#0D9488] text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shrink-0">2</span>
                <div>
                    <h3 class="font-semibold text-lg">Masukkan ke Keranjang</h3>
                    <p class="text-stone-600 mt-1">Tentukan jumlah yang diinginkan dan klik "Tambahkan ke Keranjang".</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
            <div class="flex items-start space-x-4">
                <span class="bg-[#0D9488] text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shrink-0">3</span>
                <div>
                    <h3 class="font-semibold text-lg">Checkout</h3>
                    <p class="text-stone-600 mt-1">Isi alamat pengiriman dan pilih metode pembayaran yang tersedia.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
            <div class="flex items-start space-x-4">
                <span class="bg-[#0D9488] text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shrink-0">4</span>
                <div>
                    <h3 class="font-semibold text-lg">Konfirmasi Pesanan</h3>
                    <p class="text-stone-600 mt-1">Setelah pesanan dibuat, Anda akan mendapatkan kode pesanan. Tim kami akan segera memprosesnya.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
            <div class="flex items-start space-x-4">
                <span class="bg-[#0D9488] text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shrink-0">5</span>
                <div>
                    <h3 class="font-semibold text-lg">Pesanan Sampai</h3>
                    <p class="text-stone-600 mt-1">Pesanan akan dikirim ke alamat Anda. Nikmati produk Anda!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-stone-100 rounded-xl p-6 mt-8 text-center">
        <h3 class="font-semibold mb-2">Metode Pembayaran</h3>
        <p class="text-stone-600">Kami menerima pembayaran melalui Transfer Bank (BCA, Mandiri, BRI) dan COD (Bayar di Tempat).</p>
    </div>
</div>
@endsection
