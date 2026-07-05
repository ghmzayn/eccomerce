<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        $order->load('items.product', 'shipping');

        return view('orders.show', compact('order'));
    }

    public function uploadPaymentProof(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }

        if ($order->payment_status !== 'pending') {
            return back()->with('error', 'Pembayaran sudah diproses.');
        }

        $validated = $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'payment_proof.required' => 'Pilih bukti pembayaran.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.mimes' => 'Format harus jpeg, png, jpg, atau webp.',
            'payment_proof.max' => 'Ukuran maksimal 2MB.',
        ]);

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        $order->update(['payment_proof' => $path]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }
}