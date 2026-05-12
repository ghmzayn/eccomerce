@extends('layouts.app')

@section('title', 'Keranjang Belanja - Qios')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8" style="color: #0D9488;">Keranjang Belanja</h1>

    @if(empty($cart))
        <div class="text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-stone-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
            </svg>
            <p class="text-lg text-stone-500 mb-4">Keranjang belanja kosong</p>
            <a href="{{ route('categories.index') }}" class="inline-block bg-[#0D9488] text-white px-6 py-2 rounded-lg hover:bg-[#0f766e] transition">Mulai Belanja</a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <table class="w-full">
                <thead class="bg-stone-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Produk</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Harga</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Jumlah</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Subtotal</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($cart as $item)
                        <tr>
                            <td class="px-4 py-4">
                                <div class="flex items-center space-x-3">
                                    <span class="font-medium">{{ $item['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="px-4 py-4 text-center">
                                <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="inline-flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}"
                                        class="w-16 px-2 py-1 border rounded text-center focus:ring-2 focus:ring-[#0D9488] focus:border-[#0D9488] outline-none">
                                    <button type="submit" class="text-sm text-[#0D9488] hover:underline">Update</button>
                                </form>
                            </td>
                            <td class="px-4 py-4 text-center font-semibold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            <td class="px-4 py-4 text-center">
                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-between items-center">
            <div>
                <span class="text-xl font-bold">Total: <span style="color: #0D9488;">Rp {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 0, ',', '.') }}</span></span>
            </div>
            <a href="{{ route('checkout.index') }}" class="bg-[#0D9488] text-white px-8 py-3 rounded-lg hover:bg-[#0f766e] transition font-semibold">
                Checkout
            </a>
        </div>
    @endif
</div>
@endsection
