@extends('admin.layouts.admin')

@section('title', 'Kategori')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold">Daftar Kategori</h3>
    <a href="{{ route('admin.categories.create') }}" class="bg-[#0D9488] text-white px-4 py-2 rounded-lg hover:bg-[#0f766e] transition text-sm">+ Tambah Kategori</a>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="w-full">
        <thead class="bg-stone-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Gambar</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Nama</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Jml Produk</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($categories as $category)
                <tr>
                    <td class="px-4 py-3">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-12 h-12 object-cover rounded">
                        @else
                            <div class="w-12 h-12 bg-stone-100 rounded flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                    <td class="px-4 py-3 text-center">{{ $category->products_count }}</td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-500 hover:text-blue-700 text-sm">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-stone-500">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $categories->links() }}
</div>
@endsection
