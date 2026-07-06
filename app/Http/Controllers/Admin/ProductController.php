<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with(['store', 'category', 'productVariants'])->withCount('productVariants')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $stores = Store::all();
        $categories = Category::all();

        return view('admin.products.create', compact('stores', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'nama_produk' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable',
            'variants' => 'required|array|min:1',
            'variants.*.nama_varian' => 'required|max:100',
            'variants.*.harga' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'variants.*.stok' => 'required|integer|min:0',
        ], [
            'store_id.required' => 'Toko wajib dipilih.',
            'store_id.exists' => 'Toko tidak valid.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'variants.required' => 'Minimal 1 varian produk.',
            'variants.*.nama_varian.required' => 'Nama varian wajib diisi.',
            'variants.*.harga.required' => 'Harga varian wajib diisi.',
            'variants.*.harga.numeric' => 'Harga harus berupa angka.',
            'variants.*.stok.required' => 'Stok varian wajib diisi.',
            'variants.*.stok.integer' => 'Stok harus berupa angka.',
        ]);

        $data = [
            'store_id' => $validated['store_id'],
            'nama_produk' => $validated['nama_produk'],
            'category_id' => $validated['category_id'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        foreach ($validated['variants'] as $variant) {
            ProductVariant::create([
                'product_id' => $product->id,
                'nama_varian' => $variant['nama_varian'],
                'harga' => $variant['harga'],
                'stok' => $variant['stok'],
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk beserta varian berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        $stores = Store::all();
        $categories = Category::all();
        $product->load('productVariants');

        return view('admin.products.edit', compact('product', 'stores', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'nama_produk' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable',
            'variants' => 'required|array|min:1',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.nama_varian' => 'required|max:100',
            'variants.*.harga' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'variants.*.stok' => 'required|integer|min:0',
        ]);

        $data = [
            'store_id' => $validated['store_id'],
            'nama_produk' => $validated['nama_produk'],
            'category_id' => $validated['category_id'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        // Sync variants: keep existing, update changed, delete removed
        $existingIds = $product->productVariants()->pluck('id')->toArray();
        $submittedIds = [];

        foreach ($validated['variants'] as $variant) {
            if (!empty($variant['id'])) {
                // Update existing variant
                ProductVariant::where('id', $variant['id'])->update([
                    'nama_varian' => $variant['nama_varian'],
                    'harga' => $variant['harga'],
                    'stok' => $variant['stok'],
                ]);
                $submittedIds[] = $variant['id'];
            } else {
                // Create new variant
                $new = ProductVariant::create([
                    'product_id' => $product->id,
                    'nama_varian' => $variant['nama_varian'],
                    'harga' => $variant['harga'],
                    'stok' => $variant['stok'],
                ]);
                $submittedIds[] = $new->id;
            }
        }

        // Delete variants that were removed
        $toDelete = array_diff($existingIds, $submittedIds);
        if (!empty($toDelete)) {
            ProductVariant::whereIn('id', $toDelete)->delete();
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->productVariants()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk beserta varian berhasil dihapus.');
    }
}
