<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Shipping;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public static function courierOptions(): array
    {
        return [
            'jne_reg' => ['courier' => 'JNE', 'service' => 'REG', 'cost' => 15000],
            'jne_yes' => ['courier' => 'JNE', 'service' => 'YES', 'cost' => 30000],
            'sicepat_reg' => ['courier' => 'SiCepat', 'service' => 'REG', 'cost' => 12000],
            'sicepat_halu' => ['courier' => 'SiCepat', 'service' => 'HALU', 'cost' => 25000],
            'jnt_reg' => ['courier' => 'J&T', 'service' => 'REG', 'cost' => 14000],
            'jnt_eco' => ['courier' => 'J&T', 'service' => 'ECO', 'cost' => 8000],
        ];
    }

    public function index(): View|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $total = collect($cart)->sum(fn ($item) => $item['harga'] * $item['quantity']);
        $couriers = self::courierOptions();

        return view('checkout.index', compact('cart', 'total', 'couriers'));
    }

    public function process(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $courierKeys = implode(',', array_keys(self::courierOptions()));

        $validated = $request->validate([
            'shipping_address' => 'required|min:10',
            'payment_method' => 'required|in:transfer_bca,transfer_mandiri,transfer_bri,qris,cod',
            'courier' => "required|in:$courierKeys",
            'notes' => 'nullable|max:500',
        ], [
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_address.min' => 'Alamat pengiriman minimal 10 karakter.',
            'payment_method.required' => 'Pilih metode pembayaran.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
            'courier.required' => 'Pilih kurir pengiriman.',
            'courier.in' => 'Kurir tidak valid.',
            'notes.max' => 'Catatan maksimal 500 karakter.',
        ]);

        $total = collect($cart)->sum(fn ($item) => $item['harga'] * $item['quantity']);
        $selectedCourier = self::courierOptions()[$validated['courier']];

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
                $variant = ProductVariant::with('product')->findOrFail($item['variant_id']);

                if ($variant->stok < $item['quantity']) {
                    DB::rollBack();
                    return back()->with('error', "Stok {$variant->product->nama_produk} ({$variant->nama_varian}) tidak mencukupi.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $variant->product_id,
                    'quantity' => $item['quantity'],
                    'price' => $item['harga'],
                ]);

                $variant->decrement('stok', $item['quantity']);
            }

            Shipping::create([
                'order_id' => $order->id,
                'courier' => $selectedCourier['courier'],
                'service' => $selectedCourier['service'],
                'shipping_cost' => $selectedCourier['cost'],
            ]);

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

        $order->load('shipping');

        return view('checkout.success', compact('order'));
    }
}
