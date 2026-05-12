@extends('admin.layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold">Daftar Produk</h3>
    <a href="{{ route('admin.products.create') }}" class="bg-[#0D9488] text-white px-4 py-2 rounded-lg hover:bg-[#0f766e] transition text-sm">+ Tambah Produk</a>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="w-full">
        <thead class="bg-stone-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Gambar</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Nama</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Kategori</th>
                <th class="px-4 py-3 text-right text-sm font-semibold text-stone-600">Harga</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Stok</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Promo</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($products as $product)
                <tr>
                    <td class="px-4 py-3">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                        @else
                            <div class="w-12 h-12 bg-stone-100 rounded flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $product->name }}</td>
                    <td class="px-4 py-3">{{ $product->category->name }}</td>
                    <td class="px-4 py-3 text-right">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                        @if($product->is_promo)
                            <br><span class="text-red-500 text-xs">Promo: Rp {{ number_format($product->promo_price, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">{{ $product->stock }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($product->is_promo)
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-0.5 rounded">Ya</span>
                        @else
                            <span class="text-stone-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 text-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-stone-500">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection
