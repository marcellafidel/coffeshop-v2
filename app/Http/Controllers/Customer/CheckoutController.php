<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }
        return view('customer.checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $idPesanan = 'PSN' . strtoupper(Str::random(3));

        $pesanan = Pesanan::create([
            'idPesanan'        => $idPesanan,
            'idCust'           => auth()->id(),
            'metodePembayaran' => $request->metodePembayaran,
            'catatan'          => $request->catatan,
            'tglPesanan'       => now(),
        ]);

        foreach ($cart as $item) {
            DetailPesanan::create([
                'idDetail'  => 'DTL' . strtoupper(Str::random(3)),
                'idPesanan' => $idPesanan,
                'idMenu'    => $item['idProduk'],
                'namaMenu'  => $item['namaProduk'],
                'jumlah'    => $item['jumlah'],
                'harga'     => $item['harga'],
                'subtotal'  => $item['harga'] * $item['jumlah'],
            ]);
        }

        // Buat notifikasi
        Notification::create([
            'judul' => 'Pesanan Baru!',
            'pesan' => 'Pesanan #' . $idPesanan . ' dari ' . auth()->user()->name,
            'tipe'  => 'pesanan',
            'url'   => '/admin/orders/' . $idPesanan,
        ]);

        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat!');
    }
}