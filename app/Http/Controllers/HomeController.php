<?php

namespace App\Http\Controllers;

use App\Models\Broadcast;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();
        $activeBroadcasts = Broadcast::with('store', 'product')->where('is_live', true)->latest()->get();
        $featuredProducts = Product::with('category', 'productVariants')->latest()->take(6)->get();
        $latestProducts = Product::with('category', 'productVariants')->latest()->take(8)->get();

        return view('home.index', compact('categories', 'activeBroadcasts', 'featuredProducts', 'latestProducts'));
    }
}
