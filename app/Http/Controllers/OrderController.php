<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
