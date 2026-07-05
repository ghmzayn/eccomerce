@extends('admin.layouts.admin')

@section('title', 'Siaran')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-semibold">Daftar Siaran</h3>
    <a href="{{ route('admin.broadcasts.create') }}" class="bg-[#0D9488] text-white px-4 py-2 rounded-lg hover:bg-[#0f766e] transition text-sm">+ Tambah Siaran</a>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="w-full">
        <thead class="bg-stone-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Gambar</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Judul</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Toko</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-stone-600">Produk</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Status</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-stone-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($broadcasts as $broadcast)
                <tr>
                    <td class="px-4 py-3">
                        @if($broadcast->image)
                            <img src="{{ asset('storage/' . $broadcast->image) }}" alt="{{ $broadcast->title }}" class="w-12 h-12 object-cover rounded">
                        @else
                            <div class="w-12 h-12 bg-stone-100 rounded flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" /></svg>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $broadcast->title }}</td>
                    <td class="px-4 py-3">{{ $broadcast->store->name }}</td>
                    <td class="px-4 py-3">{{ $broadcast->product?->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($broadcast->is_live)
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full font-medium">Live</span>
                        @else
                            <span class="bg-stone-100 text-stone-500 text-xs px-2 py-0.5 rounded-full font-medium">Berakhir</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('admin.broadcasts.edit', $broadcast) }}" class="text-blue-500 hover:text-blue-700 text-sm">Edit</a>
                        <form action="{{ route('admin.broadcasts.destroy', $broadcast) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-stone-500">Belum ada siaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $broadcasts->links() }}
</div>
@endsection