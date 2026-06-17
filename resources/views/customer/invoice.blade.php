<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $pesanan->idPesanan }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; padding: 40px; }

        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; }
        .brand { font-size: 24px; font-weight: 700; color: #1a1a2e; }
        .brand span { color: #A8C8E8; }
        .brand p { font-size: 12px; color: #888; font-weight: 400; margin-top: 4px; }
        .invoice-info { text-align: right; }
        .invoice-info h2 { font-size: 28px; color: #A8C8E8; font-weight: 700; margin-bottom: 4px; }
        .invoice-info p { font-size: 12px; color: #888; }

        .divider { border: none; border-top: 2px solid #A8C8E8; margin: 20px 0; }

        .info-section { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .info-box h4 { font-size: 11px; text-transform: uppercase; color: #888; margin-bottom: 8px; }
        .info-box p { font-size: 13px; color: #333; line-height: 1.6; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        thead tr { background: #A8C8E8; }
        thead th { padding: 10px 12px; text-align: left; font-size: 12px; color: #fff; text-transform: uppercase; }
        tbody tr:nth-child(even) { background: #f8fbff; }
        tbody td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #f0f0f0; }

        .summary { margin-left: auto; width: 280px; }
        .summary-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; border-bottom: 1px solid #f0f0f0; }
        .summary-total { display: flex; justify-content: space-between; padding: 10px 0; font-size: 15px; font-weight: 700; color: #A8C8E8; border-top: 2px solid #A8C8E8; margin-top: 4px; }

        .status-badge { display: inline-block; padding: 4px 14px; border-radius: 20px; font-size: 11px; background: #EFF6FF; color: #A8C8E8; font-weight: 600; }
        .status-selesai { background: #d4f4e2; color: #1a6b3c; }
        .status-batal { background: #fde8e8; color: #c0392b; }

        .footer { text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #f0f0f0; font-size: 11px; color: #aaa; }
        .thank-you { font-size: 16px; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">
            ☕ Coffe<span>Shop</span>
            <p>Kopi terbaik setiap hari</p>
        </div>
        <div class="invoice-info">
            <h2>INVOICE</h2>
            <p>#{{ $pesanan->idPesanan }}</p>
            <p>{{ \Carbon\Carbon::parse($pesanan->tglPesanan)->format('d M Y') }}</p>
        </div>
    </div>

    <hr class="divider">

    <div class="info-section">
        <div class="info-box">
            <h4>Tagihan Kepada</h4>
            <p><strong>{{ $pesanan->customer->name ?? '-' }}</strong></p>
            <p>{{ $pesanan->customer->email ?? '-' }}</p>
            <p>{{ $pesanan->customer->phone ?? '-' }}</p>
        </div>
        <div class="info-box" style="text-align:right;">
            <h4>Detail Pembayaran</h4>
            <p>Metode: <strong>{{ $pesanan->metodePembayaran }}</strong></p>
            <p>Status: <span class="status-badge status-{{ $pesanan->status ?? 'pending' }}">{{ ucfirst($pesanan->status ?? 'pending') }}</span></p>
            <p>Tanggal: {{ \Carbon\Carbon::parse($pesanan->tglPesanan)->format('d M Y') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->detailPesanans as $i => $detail)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $detail->namaMenu }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row"><span>Subtotal</span><span>Rp {{ number_format($pesanan->detailPesanans->sum('subtotal'), 0, ',', '.') }}</span></div>
        <div class="summary-row"><span>Pajak (0%)</span><span>Rp 0</span></div>
        <div class="summary-total"><span>Total</span><span>Rp {{ number_format($pesanan->detailPesanans->sum('subtotal'), 0, ',', '.') }}</span></div>
    </div>

    @if($pesanan->catatan)
    <div style="margin-top:24px;background:#f8fbff;border-radius:8px;padding:14px 16px;font-size:13px;">
        <strong>Catatan:</strong> {{ $pesanan->catatan }}
    </div>
    @endif

    <div class="footer">
        <div class="thank-you">Terima kasih telah memesan! ☕</div>
        <p>CoffeShop © {{ now()->year }} — Dokumen ini digenerate otomatis oleh sistem</p>
    </div>
</body>
</html>