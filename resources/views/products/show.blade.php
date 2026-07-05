@extends('layouts.app')

@section('title', $product->nama_produk . ' - Qios')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <nav class="mb-6 text-sm text-stone-500">
        <a href="{{ route('home') }}" class="hover:text-[#0D9488]">Home</a> /
        <a href="{{ route('categories.index') }}" class="hover:text-[#0D9488]">{{ $product->kategori }}</a> /
        <span class="text-stone-800">{{ $product->nama_produk }}</span>
    </nav>

    <div class="grid md:grid-cols-2 gap-8">
        <div class="relative">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_produk }}" class="w-full h-96 object-cover rounded-xl">
            @else
                <div class="w-full h-96 bg-stone-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
        </div>

        <div>
            <h1 class="text-3xl font-bold mb-4">{{ $product->nama_produk }}</h1>

            <div class="mb-4">
                <span class="text-3xl font-bold" style="color: #0D9488;">Mulai dari Rp {{ number_format($product->effective_price, 0, ',', '.') }}</span>
            </div>

            <div class="mb-6">
                <span class="inline-block bg-stone-100 text-stone-600 px-3 py-1 rounded-full text-sm">
                    Kategori: {{ $product->kategori }}
                </span>
                <span class="inline-block bg-stone-100 text-stone-600 px-3 py-1 rounded-full text-sm ml-2">
                    Toko: {{ $product->store->name }}
                </span>
            </div>

            @if($product->productVariants->count() > 0)
                <div class="mb-6 p-4 bg-stone-50 rounded-lg">
                    <label class="block text-sm font-medium text-stone-700 mb-3">
                        Pilih Varian
                        @php
                            $nama = strtolower($product->nama_produk);
                            if ($product->kategori === 'Pakaian') {
                                $varianLabel = 'Pilih Ukuran (Size)';
                            } elseif (str_contains($nama, 'keyboard')) {
                                $varianLabel = 'Pilih Warna';
                            } elseif (str_contains($nama, 'monitor')) {
                                $varianLabel = 'Pilih Ukuran Layar';
                            } elseif (str_contains($nama, 'laptop')) {
                                $varianLabel = 'Pilih Kapasitas Penyimpanan';
                            } else {
                                $varianLabel = 'Pilih RAM / Storage';
                            }
                        @endphp
                        {{ $varianLabel }}
                    </label>
                    <select id="variant-select" name="variant_id" class="w-full md:w-1/2 px-4 py-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none" wire:model="selectedVariantId">
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
                    <div id="variant-info" class="mt-3 p-3 bg-white rounded-lg border hidden">
                        <p class="text-lg font-bold" style="color: #0D9488;" id="variant-price">Rp 0</p>
                        <p class="text-sm text-stone-600" id="variant-stock">Stok: 0</p>
                    </div>
                </div>
            @endif

            @if($product->deskripsi && trim($product->deskripsi) !== '')
                <div class="mb-6 text-stone-600 leading-relaxed border-t border-stone-200 pt-6">
                    <h3 class="text-lg font-semibold mb-2" style="color: #0D9488;">Deskripsi Produk</h3>
                    <p>{{ $product->deskripsi }}</p>
                </div>
            @endif

            @auth
                @if($product->productVariants->where('stok', '>', 0)->count() > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        <input type="hidden" name="variant_id" id="selected-variant-id" value="">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1">Jumlah</label>
                            <input type="number" name="quantity" value="1" min="1"
                                class="w-20 px-3 py-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                        </div>
                        <button type="submit"
                            class="bg-[#0D9488] text-white px-8 py-2 rounded-lg hover:bg-[#0f766e] transition font-medium">
                            + Keranjang
                        </button>
                    </form>
                @else
                    <p class="text-red-500 font-semibold">Stok habis untuk semua varian</p>
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
                    <a href="{{ route('products.show', $related) }}" class="bg-white rounded-xl shadow-sm border hover:shadow-md transition group">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->nama_produk }}" class="w-full h-40 object-cover rounded-t-xl">
                        @else
                            <div class="w-full h-40 bg-stone-100 rounded-t-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-stone-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="p-3">
                            <h3 class="font-semibold text-sm group-hover:text-[#0D9488] transition">{{ $related->nama_produk }}</h3>
                            <span class="text-sm font-bold" style="color: #0D9488;">Rp {{ number_format($related->effective_price, 0, ',', '.') }}</span>
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