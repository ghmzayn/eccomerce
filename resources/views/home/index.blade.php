@extends('layouts.app')

@section('title', 'Qios - Toko Online Terpercaya')

@section('content')
    <div class="bg-gradient-to-br from-[#0D9488] via-[#0f766e] to-[#115e59] text-white">
        <div class="max-w-7xl mx-auto px-4 py-20 md:py-32">
            <div class="md:w-2/3 text-center md:text-left">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">Belanja Lebih<br><span class="text-[#99f6e4]">Mudah & Cepat</span></h1>
                <p class="text-lg text-stone-200 mb-8 max-w-xl">Temukan berbagai produk berkualitas dengan harga terbaik. Belanja mudah, aman, dan cepat hanya di Qios.</p>
                <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                    <a href="{{ route('categories.index') }}" class="inline-block bg-white text-[#0D9488] px-8 py-3 rounded-xl font-semibold hover:bg-stone-100 transition shadow-lg shadow-black/10">
                        Belanja Sekarang
                    </a>
                    <a href="{{ route('pages.cara-pembelian') }}" class="inline-block border-2 border-white/30 text-white px-8 py-3 rounded-xl font-semibold hover:bg-white/10 transition">
                        Cara Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4">

        @if($activeBroadcasts->count() > 0)
            <section class="py-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl md:text-2xl font-bold" style="color: #0D9488;">Siaran Promo</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($activeBroadcasts as $broadcast)
                        <div class="bg-white rounded-xl shadow-sm border border-stone-100 overflow-hidden flex flex-col md:flex-row">
                            @if($broadcast->image)
                                <img src="{{ asset('storage/' . $broadcast->image) }}" alt="{{ $broadcast->title }}" class="w-full md:w-48 h-36 object-cover">
                            @else
                                <div class="w-full md:w-48 h-36 bg-gradient-to-br from-[#0D9488]/10 to-[#0f766e]/10 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#0D9488]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                                </div>
                            @endif
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="text-xs text-stone-400">{{ $broadcast->store->name }}</span>
                                        <span class="w-1 h-1 bg-stone-300 rounded-full"></span>
                                        <span class="text-xs text-green-600 font-medium">Live</span>
                                    </div>
                                    <h3 class="font-semibold text-stone-800">{{ $broadcast->title }}</h3>
                                    @if($broadcast->description)
                                        <p class="text-sm text-stone-500 mt-1 line-clamp-2">{{ $broadcast->description }}</p>
                                    @endif
                                </div>
                                @if($broadcast->product)
                                    <a href="{{ route('products.show', $broadcast->product) }}" class="text-sm text-[#0D9488] hover:underline mt-2 font-medium">
                                        Lihat Produk &rarr;
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($categories->count() > 0)
            <section class="py-16">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold" style="color: #0D9488;">Kategori Produk</h2>
                    <a href="{{ route('categories.index') }}" class="text-[#0D9488] hover:underline font-medium text-sm">Lihat Semua &rarr;</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}" class="bg-white rounded-2xl shadow-sm border border-stone-100 hover:shadow-lg hover:border-[#0D9488]/20 transition-all duration-300 p-6 text-center group">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-20 h-20 object-cover rounded-2xl mx-auto mb-4">
                            @else
                                <div class="w-20 h-20 bg-gradient-to-br from-[#0D9488]/10 to-[#0f766e]/10 rounded-2xl mx-auto mb-4 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#0D9488]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                                </div>
                            @endif
                            <h3 class="font-semibold text-stone-800 group-hover:text-[#0D9488] transition-colors">{{ $category->name }}</h3>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if($featuredProducts->count() > 0)
            <section class="py-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold" style="color: #0D9488;">Produk Pilihan</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                    @foreach($featuredProducts as $product)
                        <a href="{{ route('products.show', $product) }}" class="bg-white rounded-2xl shadow-sm border border-stone-100 hover:shadow-lg hover:border-amber-300/40 transition-all duration-300 group overflow-hidden">
                            <div class="relative overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_produk }}" class="w-full h-52 object-cover rounded-t-2xl group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-52 bg-gradient-to-br from-amber-50 to-amber-100 rounded-t-2xl flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                @endif
                                <span class="absolute top-3 left-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-lg">PILIHAN</span>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-stone-800 group-hover:text-[#0D9488] transition-colors">{{ $product->nama_produk }}</h3>
                                <div class="mt-2">
                                    <span class="text-lg font-bold text-amber-600">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="py-12 pb-20">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-bold" style="color: #0D9488;">Produk Terbaru</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($latestProducts as $product)
                    <a href="{{ route('products.show', $product) }}" class="bg-white rounded-2xl shadow-sm border border-stone-100 hover:shadow-lg hover:border-[#0D9488]/20 transition-all duration-300 group overflow-hidden">
                        <div class="relative overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_produk }}" class="w-full h-52 object-cover rounded-t-2xl group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-52 bg-gradient-to-br from-stone-50 to-stone-100 rounded-t-2xl flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-stone-800 group-hover:text-[#0D9488] transition-colors">{{ $product->nama_produk }}</h3>
                            <div class="mt-2">
                                <span class="text-lg font-bold" style="color: #0D9488;">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

    </div>
@endsection
