<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ], [
            'variant_id.required' => 'Pilih varian produk terlebih dahulu.',
            'variant_id.exists' => 'Varian tidak valid.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah minimal 1.',
        ]);

        $variant = ProductVariant::with('product')->findOrFail($validated['variant_id']);

        if ($variant->stok < 1) {
            return back()->with('error', 'Stok varian ini habis.');
        }

        if ($validated['quantity'] > $variant->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia (Stok: ' . $variant->stok . ').');
        }

        $cart = session()->get('cart', []);
        $cartKey = 'v_' . $variant->id;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $validated['quantity'];

            if ($cart[$cartKey]['quantity'] > $variant->stok) {
                return back()->with('error', 'Jumlah melebihi stok tersedia (Stok: ' . $variant->stok . ').');
            }
        } else {
            $cart[$cartKey] = [
                'variant_id' => $variant->id,
                'product_id' => $variant->product_id,
                'nama_produk' => $variant->product->nama_produk,
                'nama_varian' => $variant->nama_varian,
                'harga' => (float) $variant->harga,
                'quantity' => $validated['quantity'],
                'stok' => $variant->stok,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::findOrFail($validated['variant_id']);

        if ($validated['quantity'] > $variant->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia.');
        }

        $cart = session()->get('cart', []);
        $cartKey = 'v_' . $variant->id;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = $validated['quantity'];
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Jumlah produk diperbarui.');
    }

    public function remove(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
        ]);

        $cart = session()->get('cart', []);
        $cartKey = 'v_' . $validated['variant_id'];

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }
}
