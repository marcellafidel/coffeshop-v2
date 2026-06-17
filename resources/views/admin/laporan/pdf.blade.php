<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan {{ $bulanNama }} {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #A8C8E8; padding-bottom: 16px; }
        .header h1 { font-size: 22px; color: #1a1a2e; margin: 0 0 4px; }
        .header p { color: #888; font-size: 13px; margin: 0; }
        .stat-row { display: flex; gap: 16px; margin-bottom: 24px; }
        .stat-box { flex: 1; background: #EFF6FF; border-radius: 8px; padding: 14px; text-align: center; }
        .stat-box .label { font-size: 11px; color: #888; text-transform: uppercase; margin-bottom: 4px; }
        .stat-box .value { font-size: 20px; font-weight: 700; color: #A8C8E8; }
        h3 { font-size: 14px; color: #1a1a2e; margin: 20px 0 10px; border-left: 4px solid #A8C8E8; padding-left: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #EFF6FF; padding: 8px 10px; text-align: left; font-size: 11px; text-transform: uppercase; color: #888; }
        td { padding: 8px 10px; border-bottom: 1px solid #f0f0f0; font-size: 12px; }
        .total-row td { font-weight: 700; background: #f9f9f9; }
        .footer { text-align: center; margin-top: 30px; font-size: 11px; color: #aaa; border-top: 1px solid #f0f0f0; padding-top: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>☕ CoffeShop — Laporan Keuangan</h1>
        <p>Periode: {{ $bulanNama }} {{ $tahun }}</p>
        <p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <div class="stat-row">
        <div class="stat-box">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="stat-box">
            <div class="label">Total Pesanan</div>
            <div class="value">{{ $totalPesanan }}</div>
        </div>
        <div class="stat-box">
            <div class="label">Rata-rata / Pesanan</div>
            <div class="value">Rp {{ $totalPesanan > 0 ? number_format($totalPendapatan / $totalPesanan, 0, ',', '.') : '0' }}</div>
        </div>
    </div>

    <h3>Produk Terlaris</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>Total Terjual</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produkTerlaris as $i => $produk)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $produk->namaMenu }}</td>
                <td>{{ $produk->total_terjual }} pcs</td>
                <td>Rp {{ number_format($produk->total_pendapatan, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:#888;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Detail Pesanan</h3>
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Customer</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesanans as $p)
            <tr>
                <td>{{ $p->idPesanan }}</td>
                <td>{{ $p->customer->nama ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tglPesanan)->format('d M Y') }}</td>
                <td>{{ $p->metodePembayaran }}</td>
                <td>Rp {{ number_format($p->detailPesanans->sum('subtotal'), 0, ',', '.') }}</td>
                <td>{{ $p->status ?? 'pending' }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#888;">Tidak ada pesanan.</td></tr>
            @endforelse
            <tr class="total-row">
                <td colspan="4">Total Keseluruhan</td>
                <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">CoffeShop © {{ $tahun }} — Dokumen ini digenerate otomatis oleh sistem</div>
</body>
</html>