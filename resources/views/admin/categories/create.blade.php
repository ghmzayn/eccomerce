@extends('admin.layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Nama Kategori</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-stone-700 mb-1">Deskripsi</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-stone-700 mb-1">Gambar</label>
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
@endsection
