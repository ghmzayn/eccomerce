@extends('layouts.app')

@section('title', 'Kategori - Qios')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8" style="color: #0D9488;">Semua Kategori</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}" class="bg-white rounded-xl shadow-sm border hover:shadow-md transition p-6 text-center group">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-24 h-24 object-cover rounded-full mx-auto mb-4">
                @else
                    <div class="w-24 h-24 bg-stone-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </div>
                @endif
                <h3 class="font-semibold text-lg group-hover:text-[#0D9488] transition">{{ $category->name }}</h3>
                @if($category->description)
                    <p class="text-sm text-stone-500 mt-2">{{ Str::limit($category->description, 60) }}</p>
                @endif
            </a>
        @empty
            <div class="col-span-4 text-center py-12 text-stone-500">
                <p class="text-lg">Belum ada kategori.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
