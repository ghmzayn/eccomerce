<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BroadcastController extends Controller
{
    public function index(): View
    {
        $broadcasts = Broadcast::with('store', 'product')->latest()->paginate(15);

        return view('admin.broadcasts.index', compact('broadcasts'));
    }

    public function create(): View
    {
        $stores = Store::all();
        $products = Product::all();

        return view('admin.broadcasts.create', compact('stores', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'title' => 'required|max:255',
            'description' => 'nullable',
            'product_id' => 'nullable|exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_live' => 'boolean',
        ], [
            'store_id.required' => 'Toko wajib dipilih.',
            'store_id.exists' => 'Toko tidak valid.',
            'title.required' => 'Judul siaran wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'product_id.exists' => 'Produk tidak valid.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = [
            'store_id' => $validated['store_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'product_id' => $validated['product_id'] ?? null,
            'is_live' => $request->boolean('is_live'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('broadcasts', 'public');
        }

        Broadcast::create($data);

        return redirect()->route('admin.broadcasts.index')->with('success', 'Siaran berhasil ditambahkan.');
    }

    public function edit(Broadcast $broadcast): View
    {
        $stores = Store::all();
        $products = Product::all();

        return view('admin.broadcasts.edit', compact('broadcast', 'stores', 'products'));
    }

    public function update(Request $request, Broadcast $broadcast): RedirectResponse
    {
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'title' => 'required|max:255',
            'description' => 'nullable',
            'product_id' => 'nullable|exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_live' => 'boolean',
        ]);

        $data = [
            'store_id' => $validated['store_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'product_id' => $validated['product_id'] ?? null,
            'is_live' => $request->boolean('is_live'),
        ];

        if ($request->hasFile('image')) {
            if ($broadcast->image) {
                Storage::disk('public')->delete($broadcast->image);
            }
            $data['image'] = $request->file('image')->store('broadcasts', 'public');
        }

        $broadcast->update($data);

        return redirect()->route('admin.broadcasts.index')->with('success', 'Siaran berhasil diperbarui.');
    }

    public function destroy(Broadcast $broadcast): RedirectResponse
    {
        if ($broadcast->image) {
            Storage::disk('public')->delete($broadcast->image);
        }

        $broadcast->delete();

        return redirect()->route('admin.broadcasts.index')->with('success', 'Siaran berhasil dihapus.');
    }
}