<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function byCategory(Category $category): View
    {
        $products = Product::with('category', 'productVariants')->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        return view('products.index', compact('category', 'products'));
    }

    public function show(Product $product): View
    {
        $product->load(['productVariants' => function ($query) {
            $query->orderBy('harga', 'asc');
        }]);

        // Cari produk terkait berdasarkan kategori yang sama
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('category', 'productVariants')
            ->latest()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
