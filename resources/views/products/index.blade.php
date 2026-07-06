@extends('layouts.app')

@section('title', $category->name . ' - Qios')

@section('content')
<div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto py-section-gap">
    <div class="mb-12 reveal">
        <a href="{{ route('categories.index') }}" class="font-label-caps text-[11px] tracking-[0.2em] text-on-surface-variant hover:text-primary transition-colors inline-block mb-6">&larr; ALL CATEGORIES</a>
        <h1 class="font-headline-lg text-[48px] editorial-spacing uppercase text-primary">{{ $category->name }}</h1>
        @if($category->description)
            <p class="font-body-md text-[16px] text-on-surface-variant mt-4 max-w-xl leading-relaxed font-light">{{ $category->description }}</p>
        @endif
    </div>

    @if($products->count() > 0)
        <div class="flex justify-between items-baseline mb-16 reveal">
            <div>
                <span class="font-label-caps text-[12px] tracking-[0.2em] text-on-surface-variant">{{ $products->total() }} Products</span>
            </div>
            <div class="flex gap-8">
                <button class="font-label-caps text-[12px] tracking-[0.2em] text-primary border-b border-primary">NEWEST</button>
                <button class="font-label-caps text-[12px] tracking-[0.2em] text-on-surface-variant">POPULAR</button>
                <button class="font-label-caps text-[12px] tracking-[0.2em] text-on-surface-variant">PRICE: LOW TO HIGH</button>
                <button class="font-label-caps text-[12px] tracking-[0.2em] text-on-surface-variant">PRICE: HIGH TO LOW</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-32 reveal">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product) }}" class="group cursor-pointer block">
                    <div class="relative aspect-[3/4] bg-white overflow-hidden mb-8">
                        @if($product->image)
                            <img alt="{{ $product->nama_produk }}" class="w-full h-full object-contain mix-blend-multiply opacity-95 group-hover:opacity-100 transition-opacity duration-700" src="{{ asset('storage/' . $product->image) }}"/>
                        @else
                            <div class="w-full h-full bg-white flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-all duration-500"></div>
                        <div class="absolute bottom-4 left-4 right-4 flex gap-2 translate-y-12 group-hover:translate-y-0 transition-transform duration-500">
                            <button class="flex-1 bg-primary text-on-primary py-3 font-label-caps text-[10px] tracking-widest">ADD TO BAG</button>
                            <button class="w-12 bg-surface text-primary border border-outline-variant/30 flex items-center justify-center"><span class="material-symbols-outlined text-sm">visibility</span></button>
                        </div>
                    </div>
                    <div class="flex flex-col items-center text-center px-4">
                        <span class="font-label-caps text-[10px] tracking-[0.3em] text-secondary mb-3 uppercase">{{ $product->category->name }}</span>
                        <h4 class="font-body-md text-[16px] text-primary mb-2 font-light tracking-wide">{{ $product->nama_produk }}</h4>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex text-[10px] text-secondary">
                                <span class="material-symbols-outlined text-[14px]">star</span>
                                <span class="material-symbols-outlined text-[14px]">star</span>
                                <span class="material-symbols-outlined text-[14px]">star</span>
                                <span class="material-symbols-outlined text-[14px]">star</span>
                                <span class="material-symbols-outlined text-[14px] opacity-30">star</span>
                            </div>
                            <span class="text-[11px] text-on-surface-variant">({{ $product->productVariants->count() }})</span>
                        </div>
                        <span class="font-body-md text-[15px] font-medium text-primary">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-16 reveal">
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
        </div>
    @else
        <div class="text-center py-24 reveal">
            <p class="font-body-lg text-[20px] text-on-surface-variant font-light">Belum ada produk di kategori ini.</p>
        </div>
    @endif
</div>
@endsection