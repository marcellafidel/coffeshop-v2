@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<style>
    .detail-card { background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 20px; animation: fadeUp 0.4s ease; }
    .info-row { display: flex; gap: 8px; margin-bottom: 10px; font-size: 14px; }
    .info-label { color: #888; min-width: 160px; }
    table { width: 100%; border-collapse: collapse; }
    th { padding: 10px 14px; text-align: left; font-size: 12px; color: #888; text-transform: uppercase; border-bottom: 2px solid #f0f0f0; }
    td { padding: 12px 14px; font-size: 14px; border-bottom: 1px solid #f5f5f5; }
    .btn-update { padding: 10px 24px; background: #A8C8E8; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s; }
    .btn-update:hover { background: #8BB5D9; }
    select { padding: 10px 16px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif; }
    .btn-back { color: #888; text-decoration: none; font-size: 14px; display: inline-block; margin-top: 16px; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="page-header">
    <h1>Detail Pesanan</h1>
    <p>#{{ $order->idPesanan }}</p>
</div>

<div class="detail-card">
    <div class="info-row"><span class="info-label">Customer</span><span>{{ $order->customer->nama ?? '-' }}</span></div>
    <div class="info-row"><span class="info-label">Tanggal Pesanan</span><span>{{ $order->tglPesanan }}</span></div>
    <div class="info-row"><span class="info-label">Metode Pembayaran</span><span>{{ $order->metodePembayaran }}</span></div>
    <div class="info-row"><span class="info-label">Catatan</span><span>{{ $order->catatan ?? '-' }}</span></div>
</div>

<div class="detail-card">
    <h3 style="font-family:'Playfair Display',serif;font-size:18px;margin-bottom:16px;">Item Pesanan</h3>
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
</div>

<div class="detail-card">
    <h3 style="font-family:'Playfair Display',serif;font-size:18px;margin-bottom:16px;">Update Status</h3>
    <form action="{{ route('admin.orders.update', $order->idPesanan) }}" method="POST" style="display:flex;gap:12px;align-items:center;">
        @csrf @method('PUT')
        <select name="status">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Proses</option>
            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="batal" {{ $order->status == 'batal' ? 'selected' : '' }}>Batal</option>
        </select>
        <button type="submit" class="btn-update">Update Status</button>
    </form>
</div>

<a href="{{ route('admin.orders.index') }}" class="btn-back">← Kembali ke Pesanan</a>
@endsection