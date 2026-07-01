@extends('layouts.customer')
@section('title', 'Riwayat Pesanan')
@section('content')
<style>
    .riwayat-wrap { max-width: 680px; margin: 0 auto; }
    .page-header { margin-bottom: 24px; }
    .page-header h1 { font-family: 'Playfair Display', serif; font-size: 28px; margin-bottom: 4px; }
    .page-header p { color: #999; font-size: 13px; }

    .pesanan-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px 20px;
        margin-bottom: 12px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: box-shadow 0.2s;
    }
    .pesanan-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.1); }

    .status-dot {
        width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
    }
    .dot-pending { background: #f1c40f; }
    .dot-confirmed { background: #A8C8E8; }
    .dot-processing { background: #9b59b6; }
    .dot-done { background: #2ecc71; }
    .dot-cancelled { background: #e74c3c; }

    .pesanan-info { flex: 1; min-width: 0; }
    .pesanan-info .id { font-weight: 700; font-size: 14px; color: #1a1a2e; }
    .pesanan-info .meta { font-size: 12px; color: #aaa; margin-top: 2px; }
    .pesanan-info .items { font-size: 13px; color: #666; margin-top: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .pesanan-right { text-align: right; flex-shrink: 0; }
    .pesanan-right .total { font-weight: 700; color: #A8C8E8; font-size: 15px; }
    .pesanan-right .actions { display: flex; gap: 6px; margin-top: 8px; justify-content: flex-end; }

    .btn-sm {
        padding: 5px 12px; border-radius: 8px; font-size: 12px;
        font-weight: 600; text-decoration: none; transition: all 0.2s;
    }
    .btn-track { background: #EFF6FF; color: #A8C8E8; }
    .btn-track:hover { background: #A8C8E8; color: #fff; }
    .btn-detail { background: #f5f5f5; color: #555; }
    .btn-detail:hover { background: #e0e0e0; }

    .empty-state { text-align: center; padding: 60px 0; }
    .empty-state p { color: #aaa; margin: 10px 0 20px; font-size: 14px; }
</style>

<div class="riwayat-wrap">
    <div class="page-header">
        <h1>Pesanan Saya</h1>
        <p>{{ $pesanans->total() }} pesanan ditemukan</p>
    </div>

    @if($pesanans->isEmpty())
    <div class="empty-state">
        <div style="font-size:48px;">📭</div>
        <p>Belum ada pesanan.</p>
        <a href="{{ route('menu') }}" style="display:inline-block;padding:10px 24px;background:#A8C8E8;color:#fff;border-radius:10px;text-decoration:none;font-weight:600;font-size:14px;">Pesan Sekarang</a>
    </div>
    @else
        @foreach($pesanans as $p)
        @php
            $status = $p->status ?? 'pending';
            $labels = [
                'pending'    => '⏳ Menunggu',
                'confirmed'  => '✓ Dikonfirmasi',
                'processing' => '🔄 Diproses',
                'done'       => '✅ Selesai',
                'cancelled'  => '❌ Dibatal',
            ];
        @endphp
        <div class="pesanan-card">
            <div class="status-dot dot-{{ $status }}"></div>
            <div class="pesanan-info">
                <div class="id">{{ $p->idPesanan }}</div>
                <div class="meta">{{ \Carbon\Carbon::parse($p->tglPesanan)->format('d M Y') }} · {{ $labels[$status] ?? $status }}</div>
                <div class="items">{{ $p->detailPesanans->pluck('namaMenu')->join(', ') }}</div>
            </div>
            <div class="pesanan-right">
                <div class="total">Rp {{ number_format($p->detailPesanans->sum('subtotal'), 0, ',', '.') }}</div>
                <div class="actions">
                    <a href="{{ route('pesanan.track', $p->idPesanan) }}" class="btn-sm btn-track">Track</a>
                    <a href="{{ route('riwayat.show', $p->idPesanan) }}" class="btn-sm btn-detail">Detail</a>
                </div>
            </div>
        </div>
        @endforeach

        <div style="margin-top:16px;">{{ $pesanans->links() }}</div>
    @endif
</div>
@endsection