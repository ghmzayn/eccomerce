@extends('layouts.app')

@section('title', 'Login - Qios')

@section('content')
<div class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center mb-2" style="color: #0D9488;">Login</h1>
        <p class="text-center text-stone-500 mb-8">Masuk ke akun Qios Anda</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-stone-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-[#0D9488] text-white py-2 rounded-lg hover:bg-[#5a3d2e] transition font-medium">
                Login
            </button>
        </form>

        <p class="text-center mt-6 text-stone-600">
            Belum punya akun? <a href="{{ route('register') }}" class="text-[#0D9488] font-medium hover:underline">Register</a>
        </p>
    </div>
</div>
@endsection
