@extends('layouts.app')

@section('title', $category->name . ' - Qios')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('categories.index') }}" class="text-stone-500 hover:text-[#0D9488] transition">&larr; Semua Kategori</a>
    </div>

    <h1 class="text-3xl font-bold mb-2" style="color: #0D9488;">{{ $category->name }}</h1>
    @if($category->description)
        <p class="text-stone-500 mb-8">{{ $category->description }}</p>
    @endif

    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="bg-white rounded-xl shadow-sm border hover:shadow-md transition group">
                    <div class="relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-t-xl">
                        @else
                            <div class="w-full h-48 bg-stone-100 rounded-t-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                        @if($product->is_promo)
                            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">PROMO</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold group-hover:text-[#0D9488] transition">{{ $product->name }}</h3>
                        <div class="mt-2">
                            <span class="text-lg font-bold" style="color: #0D9488;">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</span>
                            @if($product->is_promo)
                                <span class="text-sm text-stone-400 line-through ml-2">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <p class="text-sm text-stone-500 mt-1">Stok: {{ $product->stock }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12 text-stone-500">
            <p class="text-lg">Belum ada produk di kategori ini.</p>
        </div>
    @endif
</div>
@endsection
