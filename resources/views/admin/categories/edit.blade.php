@extends('admin.layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Nama Kategori</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-stone-700 mb-1">Deskripsi</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-stone-700 mb-1">Gambar Saat Ini</label>
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-24 h-24 object-cover rounded mb-2">
                @else
                    <p class="text-stone-400 text-sm">Tidak ada gambar</p>
                @endif
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-stone-700 mb-1">Ganti Gambar</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-[#0D9488] text-white px-6 py-2 rounded-lg hover:bg-[#0f766e] transition">
                Update
            </button>
        </form>
    </div>
</div>
@endsection
