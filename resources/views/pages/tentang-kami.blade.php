@extends('layouts.app')

@section('title', 'Tentang Kami - Qios')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-center mb-8" style="color: #0D9488;">Tentang Kami</h1>

    <div class="bg-white rounded-xl shadow-sm border p-8 mb-8">
        <h2 class="text-xl font-semibold mb-4" style="color: #0D9488;">Selamat Datang di Qios</h2>
        <p class="text-stone-600 leading-relaxed mb-4">
            Qios adalah platform belanja online terpercaya yang menyediakan berbagai produk berkualitas 
            untuk kebutuhan Anda. Dari elektronik hingga fashion, kami berkomitmen memberikan pengalaman 
            belanja yang mudah, aman, dan menyenangkan.
        </p>
        <p class="text-stone-600 leading-relaxed mb-4">
            Kami bekerja sama dengan berbagai supplier terpercaya untuk memastikan setiap produk yang 
            kami jual memiliki kualitas terbaik dengan harga yang kompetitif.
        </p>
        <p class="text-stone-600 leading-relaxed">
            Terima kasih telah mempercayakan belanja Anda kepada Qios. 
            Selamat berbelanja!
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-8">
        <h2 class="text-xl font-semibold mb-4" style="color: #0D9488;">Hubungi Kami</h2>
        <div class="space-y-2 text-stone-600">
            <p><strong>Email:</strong> hello@qios.com</p>
            <p><strong>Telepon:</strong> 0812-3456-7890</p>
            <p><strong>Alamat:</strong> Jl. Belanja No. 123, Jakarta</p>
        </div>
    </div>
</div>
@endsection
