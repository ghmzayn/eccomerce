@extends('layouts.app')

@section('title', $product->name . ' - Qios')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <nav class="mb-6 text-sm text-stone-500">
        <a href="{{ route('home') }}" class="hover:text-[#0D9488]">Home</a> /
        <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-[#0D9488]">{{ $product->category->name }}</a> /
        <span class="text-stone-800">{{ $product->name }}</span>
    </nav>

    <div class="grid md:grid-cols-2 gap-8">
        <div class="relative">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-xl">
            @else
                <div class="w-full h-96 bg-stone-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
            @endif
            @if($product->is_promo)
                <span class="absolute top-4 left-4 bg-red-500 text-white text-sm font-bold px-3 py-1 rounded">PROMO</span>
            @endif
        </div>

        <div>
            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

            <div class="mb-4">
                @if($product->is_promo && $product->promo_price)
                    <span class="text-3xl font-bold text-red-500">Rp {{ number_format($product->promo_price, 0, ',', '.') }}</span>
                    <span class="text-xl text-stone-400 line-through ml-3">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @else
                    <span class="text-3xl font-bold" style="color: #0D9488;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
            </div>

            <div class="mb-6">
                <span class="inline-block bg-stone-100 text-stone-600 px-3 py-1 rounded-full text-sm">
                    Kategori: {{ $product->category->name }}
                </span>
                <span class="inline-block bg-stone-100 text-stone-600 px-3 py-1 rounded-full text-sm ml-2">
                    Stok: {{ $product->stock }}
                </span>
            </div>

            @if($product->description)
                <div class="mb-6 text-stone-600 leading-relaxed">
                    {{ $product->description }}
                </div>
            @endif

            @auth
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1">Jumlah</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                class="w-20 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                        </div>
                        <button type="submit"
                            class="bg-[#0D9488] text-white px-8 py-2 rounded-lg hover:bg-[#0f766e] transition font-medium mt-5">
                            + Keranjang
                        </button>
                    </form>
                @else
                    <p class="text-red-500 font-semibold">Stok habis</p>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="inline-block bg-[#0D9488] text-white px-8 py-2 rounded-lg hover:bg-[#0f766e] transition font-medium">
                    Login untuk Membeli
                </a>
            @endauth
        </div>
    </div>

    @if($relatedProducts->count() > 0)
        <section class="mt-12">
            <h2 class="text-2xl font-bold mb-6" style="color: #0D9488;">Produk Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related->slug) }}" class="bg-white rounded-xl shadow-sm border hover:shadow-md transition group">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-40 object-cover rounded-t-xl">
                        @else
                            <div class="w-full h-40 bg-stone-100 rounded-t-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                        <div class="p-3">
                            <h3 class="font-semibold text-sm group-hover:text-[#0D9488] transition">{{ $related->name }}</h3>
                            <span class="text-sm font-bold" style="color: #0D9488;">Rp {{ number_format($related->effective_price, 0, ',', '.') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
