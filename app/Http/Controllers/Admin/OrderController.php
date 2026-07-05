<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('user')->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items.product', 'user', 'shipping');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function updateShipping(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'tracking_number' => 'nullable|max:100',
            'shipping_status' => 'required|in:diproses,dikirim,sampai',
        ], [
            'shipping_status.required' => 'Status pengiriman wajib dipilih.',
            'shipping_status.in' => 'Status pengiriman tidak valid.',
            'tracking_number.max' => 'Nomor resi maksimal 100 karakter.',
        ]);

        $shipping = $order->shipping;

        if (!$shipping) {
            return back()->with('error', 'Data pengiriman tidak ditemukan.');
        }

        $shipping->update([
            'tracking_number' => $validated['tracking_number'],
            'status' => $validated['shipping_status'],
        ]);

        return back()->with('success', 'Pengiriman berhasil diperbarui.');
    }

    public function updatePayment(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:paid,failed',
        ], [
            'payment_status.required' => 'Status pembayaran wajib dipilih.',
            'payment_status.in' => 'Status pembayaran tidak valid.',
        ]);

        $data = ['payment_status' => $validated['payment_status']];

        if ($validated['payment_status'] === 'paid') {
            $data['paid_at'] = now();
        }

        $order->update($data);

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
