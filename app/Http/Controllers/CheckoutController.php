<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $validated = $request->validate([
            'shipping_address' => 'required|min:10',
            'payment_method' => 'required|in:transfer_bca,transfer_mandiri,transfer_bri,cod',
            'notes' => 'nullable|max:500',
        ], [
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_address.min' => 'Alamat pengiriman minimal 10 karakter.',
            'payment_method.required' => 'Pilih metode pembayaran.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
            'notes.max' => 'Catatan maksimal 500 karakter.',
        ]);

        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_code' => 'COP-' . strtoupper(uniqid()),
                'status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'payment_method' => $validated['payment_method'],
                'total_price' => $total,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cart as $item) {
                $product = Product::findOrFail($item['id']);

                if ($product->stock < $item['quantity']) {
                    DB::rollBack();
                    return back()->with('error', "Stok {$product->name} tidak mencukupi.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('checkout.success', $order)->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function success(Order $order): View
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }

        return view('checkout.success', compact('order'));
    }
}
