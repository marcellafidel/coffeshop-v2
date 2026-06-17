<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $pesanans = Pesanan::with(['detailPesanans', 'customer'])
            ->whereMonth('tglPesanan', $bulan)
            ->whereYear('tglPesanan', $tahun)
            ->get();

        $totalPendapatan = $pesanans->sum(function ($p) {
            return $p->detailPesanans->sum('subtotal');
        });

        $totalPesanan = $pesanans->count();

        $produkTerlaris = DetailPesanan::selectRaw('namaMenu, SUM(jumlah) as total_terjual, SUM(subtotal) as total_pendapatan')
            ->whereHas('pesanan', function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tglPesanan', $bulan)->whereYear('tglPesanan', $tahun);
            })
            ->groupBy('namaMenu')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        $perHari = Pesanan::with('detailPesanans')
            ->whereMonth('tglPesanan', $bulan)
            ->whereYear('tglPesanan', $tahun)
            ->get()
            ->groupBy(fn($p) => \Carbon\Carbon::parse($p->tglPesanan)->format('d M'))
            ->map(fn($group) => $group->sum(fn($p) => $p->detailPesanans->sum('subtotal')));

        $bulanList = collect(range(1, 12))->mapWithKeys(fn($b) => [$b => \Carbon\Carbon::create()->month($b)->translatedFormat('F')]);

        return view('admin.laporan.index', compact(
            'pesanans', 'totalPendapatan', 'totalPesanan',
            'produkTerlaris', 'perHari', 'bulan', 'tahun', 'bulanList'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $pesanans = Pesanan::with(['detailPesanans', 'customer'])
            ->whereMonth('tglPesanan', $bulan)
            ->whereYear('tglPesanan', $tahun)
            ->get();

        $totalPendapatan = $pesanans->sum(fn($p) => $p->detailPesanans->sum('subtotal'));
        $totalPesanan    = $pesanans->count();

        $produkTerlaris = DetailPesanan::selectRaw('namaMenu, SUM(jumlah) as total_terjual, SUM(subtotal) as total_pendapatan')
            ->whereHas('pesanan', fn($q) => $q->whereMonth('tglPesanan', $bulan)->whereYear('tglPesanan', $tahun))
            ->groupBy('namaMenu')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        $bulanNama = \Carbon\Carbon::createFromDate(null, $bulan, 1)->format('F');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf', compact(
            'pesanans', 'totalPendapatan', 'totalPesanan', 'produkTerlaris', 'bulanNama', 'tahun'
        ));

        return $pdf->download("laporan-{$bulanNama}-{$tahun}.pdf");
    }
}