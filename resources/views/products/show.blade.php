@extends('layouts.app')

@section('title', $product->nama_produk . ' - Qios')

@section('content')
<div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto py-section-gap">
    <nav class="mb-12 reveal">
        <ol class="flex items-center gap-2 font-label-caps text-[11px] tracking-[0.2em] text-on-surface-variant">
            <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
            <li class="text-primary">/</li>
            <li><a href="{{ route('categories.index') }}" class="hover:text-primary transition-colors">{{ $product->category->name }}</a></li>
            <li class="text-primary">/</li>
            <li class="text-primary">{{ $product->nama_produk }}</li>
        </ol>
    </nav>

    <div class="grid md:grid-cols-2 gap-16 reveal">
        <div class="relative">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_produk }}" class="w-full aspect-[3/4] object-contain mix-blend-multiply bg-white"/>
            @else
                <div class="w-full aspect-[3/4] bg-white flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
        </div>

        <div class="pt-8 md:pt-0">
            <span class="font-label-caps text-[10px] tracking-[0.3em] text-secondary mb-4 uppercase block">{{ $product->category->name }}</span>
            <h1 class="font-headline-lg text-[48px] mb-8 editorial-spacing uppercase font-light text-primary">{{ $product->nama_produk }}</h1>

            <div class="mb-10">
                <span class="font-body-lg text-[28px] font-medium text-primary">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</span>
            </div>

            <div class="mb-10 flex flex-wrap gap-3">
                <span class="inline-block bg-surface-container text-on-surface-variant px-4 py-2 font-label-caps text-[10px] tracking-widest border border-outline-variant/30">
                    {{ $product->category->name }}
                </span>
                <span class="inline-block bg-surface-container text-on-surface-variant px-4 py-2 font-label-caps text-[10px] tracking-widest border border-outline-variant/30">
                    {{ $product->store->name }}
                </span>
            </div>

            @if($product->productVariants->count() > 0)
                <div class="mb-10 p-6 bg-surface-container-low rounded-xl border border-outline-variant/20">
                    <label class="block font-label-caps text-[11px] tracking-[0.2em] text-on-surface-variant mb-4 uppercase">Select Variant</label>
                    <select id="variant-select" name="variant_id" class="w-full md:w-1/2 px-6 py-4 bg-surface border border-outline-variant/30 font-body-md text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all appearance-none" wire:model="selectedVariantId">
                        <option value="">-- Pilih varian --</option>
                        @foreach($product->productVariants as $variant)
                            <option value="{{ $variant->id }}"
                                data-price="{{ $variant->harga }}"
                                data-stock="{{ $variant->stok }}"
                                {{ $variant->stok > 0 ? '' : 'disabled' }}>
                                {{ $variant->nama_varian }} - Rp {{ number_format($variant->harga, 0, ',', '.') }} {{ $variant->stok > 0 ? '(Stok: ' . $variant->stok . ')' : '(Stok Habis)' }}
                            </option>
                        @endforeach
                    </select>
                    <div id="variant-info" class="mt-4 p-4 bg-surface border border-outline-variant/20 hidden">
                        <p class="font-body-lg text-[20px] font-medium text-primary" id="variant-price">Rp 0</p>
                        <p class="font-label-sm text-[13px] text-on-surface-variant mt-1" id="variant-stock">Stok: 0</p>
                    </div>
                </div>
            @endif

            @if($product->deskripsi && trim($product->deskripsi) !== '')
                <div class="mb-10 border-t border-outline-variant/30 pt-10">
                    <h3 class="font-label-caps text-[12px] tracking-[0.2em] text-secondary mb-6 uppercase">Product Description</h3>
                    <p class="font-body-md text-[16px] text-on-surface-variant leading-relaxed font-light">{{ $product->deskripsi }}</p>
                </div>
            @endif

            @auth
                @if($product->productVariants->where('stok', '>', 0)->count() > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex items-center gap-6">
                        @csrf
                        <input type="hidden" name="variant_id" id="selected-variant-id" value="">
                        <div>
                            <label class="block font-label-caps text-[11px] tracking-[0.2em] text-on-surface-variant mb-2 uppercase">Quantity</label>
                            <input type="number" name="quantity" value="1" min="1"
                                class="w-24 px-4 py-4 bg-surface border border-outline-variant/30 font-body-md text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                        </div>
                        <button type="submit"
                            class="bg-primary text-on-primary px-12 py-4 font-label-caps text-[13px] tracking-widest hover:bg-on-surface-variant transition-all cta-hover">
                            ADD TO BAG
                        </button>
                    </form>
                @else
                    <p class="font-body-md text-[16px] text-error font-medium">Out of stock for all variants</p>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="inline-block bg-primary text-on-primary px-12 py-4 font-label-caps text-[13px] tracking-widest hover:bg-on-surface-variant transition-all cta-hover">
                    Login to Purchase
                </a>
            @endauth
        </div>
    </div>

    @if($relatedProducts->count() > 0)
        <section class="mt-32 reveal">
            <div class="flex justify-between items-baseline mb-16">
                <h2 class="font-headline-lg text-[48px] editorial-spacing uppercase">You May Also Like</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-x-12 gap-y-20">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related) }}" class="group cursor-pointer block">
                        <div class="relative aspect-[3/4] bg-white overflow-hidden mb-6">
                            @if($related->image)
                                <img alt="{{ $related->nama_produk }}" class="w-full h-full object-contain mix-blend-multiply opacity-95 group-hover:opacity-100 transition-opacity duration-700" src="{{ asset('storage/' . $related->image) }}"/>
                            @else
                                <div class="w-full h-full bg-white flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-all duration-500"></div>
                        </div>
                        <div class="flex flex-col items-center text-center px-2">
                            <span class="font-label-caps text-[10px] tracking-[0.3em] text-secondary mb-2 uppercase">{{ $related->category->name }}</span>
                            <h3 class="font-body-md text-[15px] text-primary mb-1 font-light tracking-wide">{{ $related->nama_produk }}</h3>
                            <span class="font-body-md text-[14px] font-medium text-primary">Rp {{ number_format($related->effective_price, 0, ',', '.') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const variantSelect = document.getElementById('variant-select');
        const variantInfo = document.getElementById('variant-info');
        const variantPrice = document.getElementById('variant-price');
        const variantStock = document.getElementById('variant-stock');
        const selectedVariantId = document.getElementById('selected-variant-id');

        if (variantSelect) {
            variantSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const price = selectedOption.dataset.price;
                    const stock = selectedOption.dataset.stock;

                    variantPrice.textContent = 'Rp ' + Number(price).toLocaleString('id-ID');
                    variantStock.textContent = 'Stok: ' + stock;
                    selectedVariantId.value = selectedOption.value;

                    variantInfo.classList.remove('hidden');
                } else {
                    variantInfo.classList.add('hidden');
                    selectedVariantId.value = '';
                }
            });
        }
    });
</script>
@endpush
@endsection