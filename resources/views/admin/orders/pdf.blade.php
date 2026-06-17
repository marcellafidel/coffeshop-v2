<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan {{ $order->idPesanan }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 24px; border-bottom: 2px solid #A8C8E8; padding-bottom: 16px; }
        .header h1 { font-size: 20px; color: #1a1a2e; margin: 0 0 4px; }
        .header p { color: #888; font-size: 12px; margin: 2px 0; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 6px 0; font-size: 13px; }
        .info-table td:first-child { color: #888; width: 160px; }
        h3 { font-size: 14px; color: #1a1a2e; margin: 20px 0 10px; border-left: 4px solid #A8C8E8; padding-left: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #EFF6FF; padding: 8px 10px; text-align: left; font-size: 11px; text-transform: uppercase; color: #888; }
        td { padding: 8px 10px; border-bottom: 1px solid #f0f0f0; font-size: 12px; }
        .total-row { display: flex; justify-content: space-between; margin-top: 16px; padding-top: 12px; border-top: 2px solid #A8C8E8; font-weight: 700; font-size: 14px; }
        .total-row span:last-child { color: #A8C8E8; }
        .status { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; background: #EFF6FF; color: #A8C8E8; }
        .footer { text-align: center; margin-top: 30px; font-size: 11px; color: #aaa; border-top: 1px solid #f0f0f0; padding-top: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>☕ CoffeShop — Nota Pesanan</h1>
        <p>ID Pesanan: {{ $order->idPesanan }}</p>
        <p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <h3>Info Pesanan</h3>
    <table class="info-table">
        <tr><td>Customer</td><td>{{ $order->customer->nama ?? '-' }}</td></tr>
        <tr><td>Tanggal</td><td>{{ \Carbon\Carbon::parse($order->tglPesanan)->format('d M Y') }}</td></tr>
        <tr><td>Metode Pembayaran</td><td>{{ $order->metodePembayaran }}</td></tr>
        <tr><td>Catatan</td><td>{{ $order->catatan ?? '-' }}</td></tr>
        <tr><td>Status</td><td><span class="status">{{ $order->status ?? 'pending' }}</span></td></tr>
    </table>

    <h3>Item Pesanan</h3>
    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->detailPesanans as $detail)
            <tr>
                <td>{{ $detail->namaMenu }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-row">
        <span>Total Pembayaran</span>
        <span>Rp {{ number_format($order->detailPesanans->sum('subtotal'), 0, ',', '.') }}</span>
    </div>

    <div class="footer">CoffeShop © {{ now()->year }} — Terima kasih telah memesan!</div>
</body>
</html>