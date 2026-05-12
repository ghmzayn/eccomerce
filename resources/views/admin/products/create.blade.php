@extends('admin.layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-stone-700 mb-1">Kategori</label>
                <select id="category_id" name="category_id" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('category_id') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Nama Produk</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-stone-700 mb-1">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-stone-700 mb-1">Harga</label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" required step="0.01"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-stone-700 mb-1">Stok</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('stock') border-red-500 @enderror">
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="is_promo" name="is_promo" value="1" {{ old('is_promo') ? 'checked' : '' }}
                        class="rounded focus:ring-[#0D9488]">
                    <label for="is_promo" class="text-sm font-medium text-stone-700">Aktifkan Promo</label>
                </div>
            </div>

            <div class="mb-4" id="promo_price_container" style="{{ old('is_promo') ? '' : 'display:none' }}">
                <label for="promo_price" class="block text-sm font-medium text-stone-700 mb-1">Harga Promo</label>
                <input type="number" id="promo_price" name="promo_price" value="{{ old('promo_price') }}" step="0.01"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('promo_price') border-red-500 @enderror">
                @error('promo_price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-stone-700 mb-1">Gambar Produk</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-[#0D9488] text-white px-6 py-2 rounded-lg hover:bg-[#0f766e] transition">
                Simpan
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('is_promo')?.addEventListener('change', function() {
        document.getElementById('promo_price_container').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endpush
@endsection
