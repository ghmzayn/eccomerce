<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function byCategory(Category $category): View
    {
        $products = $category->products()->latest()->paginate(12);

        return view('products.index', compact('category', 'products'));
    }

    public function show(Product $product): View
    {
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
