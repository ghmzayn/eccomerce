@extends('admin.layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="bg-white rounded-xl shadow-sm border p-6">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="store_id" class="block text-sm font-medium text-stone-700 mb-1">Toko</label>
                <select id="store_id" name="store_id" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('store_id') border-red-500 @enderror">
                    <option value="">Pilih Toko</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ old('store_id', $product->store_id) == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                    @endforeach
                </select>
                @error('store_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kategori" class="block text-sm font-medium text-stone-700 mb-1">Kategori</label>
                <select id="kategori" name="kategori" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('kategori') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}" {{ old('kategori', $product->kategori) == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('kategori')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="nama_produk" class="block text-sm font-medium text-stone-700 mb-1">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('nama_produk') border-red-500 @enderror">
            @error('nama_produk')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-stone-700 mb-1">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">{{ old('deskripsi', $product->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-stone-700 mb-1">Foto Produk</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_produk }}" class="w-32 h-32 object-cover rounded-lg border">
                </div>
            @else
                <p class="text-stone-400 text-sm mb-2">Belum ada foto</p>
            @endif
            <input type="file" id="image" name="image" accept="image/*"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
            <p class="text-xs text-stone-400 mt-1">Kosongkan jika tidak ingin mengganti foto</p>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <hr class="my-6">

        <div class="flex items-center justify-between mb-4">
            <h4 class="font-semibold text-stone-700">Varian Produk</h4>
            <button type="button" id="add-variant" class="bg-stone-100 text-stone-600 px-3 py-1.5 rounded-lg hover:bg-stone-200 transition text-sm font-medium">
                + Tambah Varian
            </button>
        </div>

        @error('variants')
            <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
        @enderror

        <div id="variants-container">
            @foreach($product->productVariants as $index => $variant)
                <div class="variant-row bg-stone-50 rounded-lg p-4 mb-3 border">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-stone-600">Varian #{{ $loop->iteration }}</span>
                        <button type="button" class="remove-variant text-red-500 hover:text-red-700 transition text-sm">Hapus</button>
                    </div>
                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-stone-600 mb-1">Nama Varian</label>
                            <input type="text" name="variants[{{ $index }}][nama_varian]" value="{{ $variant->nama_varian }}" required
                                class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-stone-600 mb-1">Harga (Rp)</label>
                            <input type="number" name="variants[{{ $index }}][harga]" value="{{ $variant->harga }}" required min="0" step="0.01"
                                class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-stone-600 mb-1">Stok</label>
                            <input type="number" name="variants[{{ $index }}][stok]" value="{{ $variant->stok }}" required min="0"
                                class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-[#0D9488] text-white px-6 py-2 rounded-lg hover:bg-[#0f766e] transition font-medium">
                Update Produk
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('variants-container');
        const addBtn = document.getElementById('add-variant');
        let variantIndex = {{ $product->productVariants->count() }};

        addBtn.addEventListener('click', function() {
            const row = document.createElement('div');
            row.className = 'variant-row bg-stone-50 rounded-lg p-4 mb-3 border';
            row.innerHTML = `
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-stone-600">Varian #${variantIndex + 1}</span>
                    <button type="button" class="remove-variant text-red-500 hover:text-red-700 transition text-sm">Hapus</button>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-stone-600 mb-1">Nama Varian</label>
                        <input type="text" name="variants[${variantIndex}][nama_varian]" required placeholder="Mis: S, M, L"
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-stone-600 mb-1">Harga (Rp)</label>
                        <input type="number" name="variants[${variantIndex}][harga]" required min="0" step="0.01"
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-stone-600 mb-1">Stok</label>
                        <input type="number" name="variants[${variantIndex}][stok]" required min="0"
                            class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                    </div>
                </div>
            `;
            container.appendChild(row);
            variantIndex++;

            row.querySelector('.remove-variant').addEventListener('click', function() {
                row.remove();
            });
        });

        // Enable remove on existing rows
        document.querySelectorAll('.remove-variant').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.variant-row').remove();
            });
        });
    });
</script>
@endpush
@endsection
