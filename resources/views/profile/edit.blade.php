@extends('layouts.app')

@section('title', 'Profil - Qios')

@section('content')
<div class="max-w-lg mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center mb-8" style="color: #0D9488;">Profil Saya</h1>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-stone-700 mb-1">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="address" class="block text-sm font-medium text-stone-700 mb-1">Alamat</label>
                <textarea id="address" name="address" rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-[#0D9488] text-white py-2 rounded-lg hover:bg-[#0f766e] transition font-medium">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
