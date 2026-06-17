@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
<style>
    .table-card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); animation: fadeUp 0.4s ease; }
    table { width: 100%; border-collapse: collapse; }
    th { padding: 10px 14px; text-align: left; font-size: 12px; color: #888; text-transform: uppercase; border-bottom: 2px solid #f0f0f0; }
    td { padding: 12px 14px; font-size: 14px; border-bottom: 1px solid #f5f5f5; }
    tr:last-child td { border-bottom: none; }
    .btn-detail { padding: 5px 12px; background: #EFF6FF; color: #A8C8E8; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; }
    .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; background: #EFF6FF; color: #A8C8E8; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="page-header">
    <h1>Pesanan</h1>
    <p>Kelola semua pesanan masuk</p>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Customer</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->idPesanan }}</td>
                <td>{{ $order->customer->nama ?? '-' }}</td>
                <td>{{ $order->tglPesanan }}</td>
                <td>{{ $order->metodePembayaran }}</td>
                <td><span class="status-badge">{{ $order->status ?? 'pending' }}</span></td>
                <td><a href="{{ route('admin.orders.show', $order->idPesanan) }}" class="btn-detail">Detail</a></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#888;padding:24px;">Belum ada pesanan.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:16px;">{{ $orders->links() }}</div>
</div>
@endsection