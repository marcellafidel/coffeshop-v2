@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<style>
    .stat-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; margin-bottom: 32px; }
    .stat-card { background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); animation: fadeUp 0.4s ease both; }
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-label { font-size: 13px; color: #888; margin-bottom: 8px; }
    .stat-value { font-family: 'Playfair Display', serif; font-size: 40px; color: #A8C8E8; }
    .section-title { font-family: 'Playfair Display', serif; font-size: 22px; margin-bottom: 16px; }
    .table-card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); animation: fadeUp 0.5s ease; }
    table { width: 100%; border-collapse: collapse; }
    th { padding: 10px 14px; text-align: left; font-size: 12px; color: #888; text-transform: uppercase; border-bottom: 2px solid #f0f0f0; }
    td { padding: 12px 14px; font-size: 14px; border-bottom: 1px solid #f5f5f5; }
    tr:last-child td { border-bottom: none; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="page-header">
    <h1>Dashboard</h1>
    <p>Selamat datang, {{ auth()->user()->name }}</p>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-value">{{ $totalPesanan }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Menu</div>
        <div class="stat-value">{{ $totalMenu }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Customer</div>
        <div class="stat-value">{{ $totalCustomer }}</div>
    </div>
</div>

<div class="section-title">Pesanan Terbaru</div>
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Customer</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesananTerbaru as $pesanan)
            <tr>
                <td>{{ $pesanan->idPesanan }}</td>
                <td>{{ $pesanan->customer->nama ?? '-' }}</td>
                <td>{{ $pesanan->tglPesanan }}</td>
                <td><span style="background:#EFF6FF;color:#A8C8E8;padding:4px 12px;border-radius:20px;font-size:12px;">{{ $pesanan->status ?? 'pending' }}</span></td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:#888;padding:24px;">Belum ada pesanan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection