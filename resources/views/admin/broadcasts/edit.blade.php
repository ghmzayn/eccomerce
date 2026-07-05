@extends('admin.layouts.admin')

@section('title', 'Edit Siaran')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <form action="{{ route('admin.broadcasts.update', $broadcast) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="store_id" class="block text-sm font-medium text-stone-700 mb-1">Toko</label>
                <select id="store_id" name="store_id" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('store_id') border-red-500 @enderror">
                    <option value="">Pilih Toko</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ old('store_id', $broadcast->store_id) == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                    @endforeach
                </select>
                @error('store_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-stone-700 mb-1">Judul Siaran</label>
                <input type="text" id="title" name="title" value="{{ old('title', $broadcast->title) }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-stone-700 mb-1">Deskripsi Promosi</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">{{ old('description', $broadcast->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="product_id" class="block text-sm font-medium text-stone-700 mb-1">Produk Unggulan (opsional)</label>
                <select id="product_id" name="product_id"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('product_id') border-red-500 @enderror">
                    <option value="">Tidak ada</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $broadcast->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-stone-700 mb-1">Gambar Saat Ini</label>
                @if($broadcast->image)
                    <img src="{{ asset('storage/' . $broadcast->image) }}" alt="{{ $broadcast->title }}" class="w-24 h-24 object-cover rounded mb-2">
                @else
                    <p class="text-stone-400 text-sm">Tidak ada gambar</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-stone-700 mb-1">Ganti Gambar</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="is_live" name="is_live" value="1" {{ old('is_live', $broadcast->is_live) ? 'checked' : '' }}
                        class="rounded focus:ring-[#0D9488]">
                    <label for="is_live" class="text-sm font-medium text-stone-700">Siaran Aktif</label>
                </div>
            </div>

            <button type="submit" class="bg-[#0D9488] text-white px-6 py-2 rounded-lg hover:bg-[#0f766e] transition">
                Update
            </button>
        </form>
    </div>
</div>
@endsection