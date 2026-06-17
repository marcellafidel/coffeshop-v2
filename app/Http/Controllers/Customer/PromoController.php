<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate(['kode' => 'required|string']);

        $promo = Promo::where('kode', strtoupper($request->kode))->first();

        if (!$promo || !$promo->isValid()) {
            return back()->withErrors(['kode' => 'Kode promo tidak valid atau sudah kadaluarsa.']);
        }

        $cart  = session()->get('cart', []);
        $total = collect($cart)->sum(fn($i) => $i['harga'] * $i['jumlah']);

        if ($total < $promo->min_belanja) {
            return back()->withErrors(['kode' => 'Minimum belanja Rp ' . number_format($promo->min_belanja, 0, ',', '.') . ' untuk menggunakan promo ini.']);
        }

        session()->put('promo', [
            'kode'   => $promo->kode,
            'nama'   => $promo->nama,
            'diskon' => $promo->hitungDiskon($total),
        ]);

        return back()->with('success', 'Promo berhasil diterapkan!');
    }

    public function remove()
    {
        session()->forget('promo');
        return back()->with('success', 'Promo dihapus.');
    }
}