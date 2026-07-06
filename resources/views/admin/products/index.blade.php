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
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Nama Produk</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Kategori</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Toko</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Varian</th>
                <th class="px-4 py-3 text-right text-sm font-semibold text-stone-600">Harga Mulai</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($products as $product)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $product->nama_produk }}</td>
                    <td class="px-4 py-3">{{ $product->category->name }}</td>
                    <td class="px-4 py-3">{{ $product->store->name }}</td>
                    <td class="px-4 py-3 text-center">{{ $product->product_variants_count }} varian</td>
                    <td class="px-4 py-3 text-right">Rp {{ number_format($product->effective_price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 text-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm" onclick="return confirm('Yakin ingin menghapus produk beserta semua variannya?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-stone-500">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection
