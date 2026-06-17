@extends('layouts.customer')
@section('title', 'Detail Pesanan')
@section('content')
<style>
    .detail-wrap { max-width:680px; margin:0 auto; }
    .detail-card { background:#fff; border-radius:16px; padding:28px; box-shadow:0 2px 12px rgba(0,0,0,0.06); margin-bottom:20px; animation:fadeUp 0.4s ease; }
    .detail-card h3 { font-family:'Playfair Display',serif; font-size:18px; margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid #f0f0f0; }
    .info-row { display:flex; gap:8px; margin-bottom:10px; font-size:14px; }
    .info-label { color:#888; min-width:160px; }
    table { width:100%; border-collapse:collapse; }
    th { padding:10px 0; text-align:left; font-size:12px; color:#888; text-transform:uppercase; border-bottom:2px solid #f0f0f0; }
    td { padding:12px 0; font-size:14px; border-bottom:1px solid #f5f5f5; }
    tr:last-child td { border-bottom:none; }
    .total-row { display:flex; justify-content:space-between; margin-top:16px; padding-top:16px; border-top:2px solid #f0f0f0; font-weight:700; font-size:16px; }
    .total-row span:last-child { color:#A8C8E8; }
    .status-badge { padding:6px 16px; border-radius:20px; font-size:13px; font-weight:600; }
    .status-pending { background:#fff3cd; color:#d4a017; }
    .status-proses { background:#EFF6FF; color:#A8C8E8; }
    .status-selesai { background:#d4f4e2; color:#1a6b3c; }
    .status-batal { background:#fde8e8; color:#c0392b; }
    .btn-back { color:#888; text-decoration:none; font-size:14px; display:inline-block; margin-top:4px; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="detail-wrap">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div>
            <h1 style="font-family:'Playfair Display',serif;font-size:28px;">Detail Pesanan</h1>
            <a href="{{ route('riwayat.index') }}" class="btn-back">← Kembali ke Riwayat</a>
        </div>
        @php $status = $pesanan->status ?? 'pending'; @endphp
        <span class="status-badge status-{{ $status }}">
            {{ $status == 'pending' ? '⏳ Menunggu' : ($status == 'proses' ? '🔄 Diproses' : ($status == 'selesai' ? '✅ Selesai' : '❌ Dibatal')) }}
        </span>
    </div>

    <div class="detail-card">
        <h3>📋 Info Pesanan</h3>
        <div class="info-row"><span class="info-label">ID Pesanan</span><span>{{ $pesanan->idPesanan }}</span></div>
        <div class="info-row"><span class="info-label">Tanggal</span><span>{{ \Carbon\Carbon::parse($pesanan->tglPesanan)->format('d M Y') }}</span></div>
        <div class="info-row"><span class="info-label">Metode Pembayaran</span><span>{{ $pesanan->metodePembayaran }}</span></div>
        <div class="info-row"><span class="info-label">Catatan</span><span>{{ $pesanan->catatan ?? '-' }}</span></div>
    </div>

    <div class="detail-card">
        <h3>🛒 Item Pesanan</h3>
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
                @foreach($pesanan->detailPesanans as $detail)
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
            <span>Total</span>
            <span>Rp {{ number_format($pesanan->detailPesanans->sum('subtotal'), 0, ',', '.') }}</span>
        </div>
    </div>
</div>
@endsection