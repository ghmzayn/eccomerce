<?php

namespace App\Http\Controllers;

use App\Models\Product;
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

    public function add(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ], [
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah minimal 1.',
            'quantity.max' => 'Jumlah melebihi stok tersedia.',
        ]);

        if ($product->stock < 1) {
            return back()->with('error', 'Stok produk habis.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;

            if ($cart[$product->id]['quantity'] > $product->stock) {
                return back()->with('error', 'Jumlah melebihi stok tersedia.');
            }
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->effective_price,
                'image' => $product->image,
                'quantity' => $request->quantity,
                'stock' => $product->stock,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ], [
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah minimal 1.',
            'quantity.max' => 'Jumlah melebihi stok tersedia.',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Jumlah produk diperbarui.');
    }

    public function remove(Product $product): RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }
}
