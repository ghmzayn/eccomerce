<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function byCategory(Category $category): View
    {
        // Query by kategori string, not by category_id (which doesn't exist in new schema)
        $products = Product::where('kategori', $category->name)
            ->with('productVariants')
            ->latest()
            ->paginate(12);

        return view('products.index', compact('category', 'products'));
    }

    public function show(Product $product): View
    {
        $product->load(['productVariants' => function ($query) {
            $query->orderBy('harga', 'asc');
        }]);

        // Cari produk terkait berdasarkan kategori string yang sama
        $relatedProducts = Product::where('kategori', $product->kategori)
            ->where('id', '!=', $product->id)
            ->with('productVariants')
            ->latest()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
