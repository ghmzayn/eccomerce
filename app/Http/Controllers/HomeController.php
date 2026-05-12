<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();
        $latestProducts = Product::latest()->take(8)->get();
        $promoProducts = Product::where('is_promo', true)->latest()->take(4)->get();

        return view('home.index', compact('categories', 'latestProducts', 'promoProducts'));
    }
}
