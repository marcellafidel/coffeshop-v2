@extends('layouts.customer')
@section('title', 'Riwayat Pesanan')
@section('content')
<style>
    .page-header { margin-bottom:28px; animation:fadeUp 0.4s ease; }
    .page-header h1 { font-family:'Playfair Display',serif; font-size:32px; }
    .pesanan-list { display:flex; flex-direction:column; gap:16px; }
    .pesanan-card { background:#fff; border-radius:16px; padding:22px 26px; box-shadow:0 2px 12px rgba(0,0,0,0.06); transition:all 0.2s; animation:fadeUp 0.4s ease both; border-left:4px solid #e8e8e8; }
    .pesanan-card:hover { box-shadow:0 8px 24px rgba(0,0,0,0.1); transform:translateY(-2px); }
    .pesanan-card.pending { border-left-color:#f1c40f; }
    .pesanan-card.proses { border-left-color:#A8C8E8; }
    .pesanan-card.selesai { border-left-color:#2ecc71; }
    .pesanan-card.batal { border-left-color:#e74c3c; }
    .pesanan-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
    .pesanan-id { font-weight:700; font-size:15px; }
    .pesanan-date { font-size:13px; color:#aaa; }
    .pesanan-items { font-size:13px; color:#888; margin-bottom:12px; }
    .pesanan-footer { display:flex; justify-content:space-between; align-items:center; }
    .pesanan-total { font-weight:700; color:#A8C8E8; font-size:16px; }
    .status-badge { padding:5px 14px; border-radius:20px; font-size:12px; font-weight:600; }
    .status-pending { background:#fff3cd; color:#d4a017; }
    .status-proses { background:#EFF6FF; color:#A8C8E8; }
    .status-selesai { background:#d4f4e2; color:#1a6b3c; }
    .status-batal { background:#fde8e8; color:#c0392b; }
    .btn-detail { padding:7px 18px; background:#EFF6FF; color:#A8C8E8; text-decoration:none; border-radius:8px; font-size:13px; font-weight:600; transition:all 0.2s; }
    .btn-detail:hover { background:#A8C8E8; color:#fff; }
    .empty-state { text-align:center; padding:80px 0; }
    .empty-state p { color:#888; margin-top:12px; margin-bottom:24px; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-header">
    <h1>Riwayat Pesanan</h1>
    <p>Semua pesanan yang pernah kamu buat</p>
</div>

@if($pesanans->isEmpty())
<div class="empty-state">
    <div style="font-size:60px;">📋</div>
    <p>Belum ada pesanan.</p>
    <a href="{{ route('menu') }}" style="display:inline-block;padding:12px 28px;background:#A8C8E8;color:#fff;border-radius:10px;text-decoration:none;font-weight:600;">Pesan Sekarang</a>
</div>
@else
<div class="pesanan-list">
    @foreach($pesanans as $p)
    @php $status = $p->status ?? 'pending'; @endphp
    <div class="pesanan-card {{ $status }}">
        <div class="pesanan-header">
            <div>
                <div class="pesanan-id">{{ $p->idPesanan }}</div>
                <div class="pesanan-date">{{ \Carbon\Carbon::parse($p->tglPesanan)->format('d M Y') }}</div>
            </div>
            <span class="status-badge status-{{ $status }}">
                {{ $status == 'pending' ? '⏳ Menunggu' : ($status == 'proses' ? '🔄 Diproses' : ($status == 'selesai' ? '✅ Selesai' : '❌ Dibatal')) }}
            </span>
        </div>
        <div class="pesanan-items">
            {{ $p->detailPesanans->count() }} item —
            {{ $p->detailPesanans->pluck('namaMenu')->join(', ') }}
        </div>
        <div class="pesanan-footer">
            <div class="pesanan-total">Rp {{ number_format($p->detailPesanans->sum('subtotal'), 0, ',', '.') }}</div>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('pesanan.track', $p->idPesanan) }}" class="btn-detail">📍 Track</a>
                <a href="{{ route('riwayat.show', $p->idPesanan) }}" class="btn-detail" style="background:#f5f5f5;color:#555;">Detail →</a>
            </div>
        </div>
    @endforeach
</div>
<div style="margin-top:24px;">{{ $pesanans->links() }}</div>
@endif
@endsection