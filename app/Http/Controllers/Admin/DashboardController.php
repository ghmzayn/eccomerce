<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::whereNot('status', 'cancelled')->sum('total_price');
        $totalUsers = User::count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $liveBroadcasts = Broadcast::with('store', 'product')->where('is_live', true)->latest()->get();

        return view('admin.dashboard.index', compact(
            'totalProducts', 'totalCategories', 'totalOrders',
            'totalRevenue', 'totalUsers', 'recentOrders', 'liveBroadcasts'
        ));
    }
}
