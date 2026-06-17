<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;

class RiwayatController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with(['detailPesanans', 'customer'])
            ->where('idCust', auth()->id())
            ->latest('tglPesanan')
            ->paginate(10);

        return view('customer.riwayat', compact('pesanans'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['detailPesanans', 'customer'])
            ->where('idCust', auth()->id())
            ->findOrFail($id);

        return view('customer.riwayat-detail', compact('pesanan'));
    }

    public function invoice($id)
    {
        $pesanan = Pesanan::with(['detailPesanans', 'customer'])
            ->where('idCust', auth()->id())
            ->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('customer.invoice', compact('pesanan'));
        return $pdf->download("invoice-{$pesanan->idPesanan}.pdf");
    }

    public function track($id)
    {
        $pesanan = Pesanan::with(['detailPesanans', 'customer'])
            ->where('idCust', auth()->id())
            ->findOrFail($id);

        return view('customer.track', compact('pesanan'));
    }
}