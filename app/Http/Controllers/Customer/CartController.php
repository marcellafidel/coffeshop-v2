<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('customer.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $menu = Menu::findOrFail($request->idProduk);
        $cart = session()->get('cart', []);

        if (isset($cart[$menu->idProduk])) {
            $cart[$menu->idProduk]['jumlah'] += $request->jumlah ?? 1;
        } else {
            $cart[$menu->idProduk] = [
                'idProduk'   => $menu->idProduk,
                'namaProduk' => $menu->namaProduk,
                'harga'      => $menu->harga,
                'jumlah'     => $request->jumlah ?? 1,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang!');
    }
}   