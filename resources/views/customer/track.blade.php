@extends('layouts.customer')
@section('title', 'Track Pesanan')
@section('content')
<style>
    .track-wrap { max-width: 680px; margin: 0 auto; }
    .track-header { margin-bottom: 28px; animation: fadeUp 0.4s ease; }
    .track-header h1 { font-family: 'Playfair Display', serif; font-size: 32px; }
    .track-header p { color: #888; margin-top: 4px; }

    .info-card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 24px; animation: fadeUp 0.4s ease; }
    .info-card h3 { font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #f0f0f0; }
    .info-row { display: flex; gap: 8px; margin-bottom: 10px; font-size: 14px; }
    .info-label { color: #888; min-width: 160px; }

    /* TIMELINE */
    .timeline-card { background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 24px; animation: fadeUp 0.5s ease; }
    .timeline-card h3 { font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 24px; }
    .timeline { position: relative; padding-left: 40px; }
    .timeline::before { content: ''; position: absolute; left: 14px; top: 0; bottom: 0; width: 2px; background: #e8e8e8; }
    .timeline-item { position: relative; margin-bottom: 28px; }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-dot { position: absolute; left: -32px; top: 2px; width: 20px; height: 20px; border-radius: 50%; background: #e8e8e8; border: 3px solid #fff; box-shadow: 0 0 0 2px #e8e8e8; display: flex; align-items: center; justify-content: center; font-size: 10px; transition: all 0.3s; }
    .timeline-dot.active { background: #A8C8E8; box-shadow: 0 0 0 3px rgba(168,200,232,0.3); animation: pulse 2s infinite; }
    .timeline-dot.done { background: #2ecc71; box-shadow: 0 0 0 2px #2ecc71; }
    .timeline-dot.cancelled { background: #e74c3c; box-shadow: 0 0 0 2px #e74c3c; }
    @keyframes pulse { 0%,100% { box-shadow: 0 0 0 3px rgba(168,200,232,0.3); } 50% { box-shadow: 0 0 0 6px rgba(168,200,232,0.1); } }
    .timeline-content { padding-left: 8px; }
    .timeline-title { font-weight: 600; font-size: 15px; color: #1a1a2e; margin-bottom: 4px; }
    .timeline-title.inactive { color: #bbb; }
    .timeline-desc { font-size: 13px; color: #888; }
    .timeline-time { font-size: 11px; color: #aaa; margin-top: 4px; }

    .btn-back { color: #888; text-decoration: none; font-size: 14px; display: inline-block; margin-bottom: 24px; }
    .btn-invoice { display: inline-block; padding: 10px 22px; background: #A8C8E8; color: #fff; text-decoration: none; border-radius: 10px; font-size: 14px; font-weight: 600; margin-top: 8px; transition: all 0.2s; }
    .btn-invoice:hover { background: #8BB5D9; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="track-wrap">
    <a href="{{ route('riwayat.index') }}" class="btn-back">← Kembali ke Riwayat</a>

    <div class="track-header">
        <h1>Track Pesanan</h1>
        <p>Status pesanan #{{ $pesanan->idPesanan }}</p>
    </div>

    {{-- INFO PESANAN --}}
    <div class="info-card">
        <h3>📋 Info Pesanan</h3>
        <div class="info-row"><span class="info-label">ID Pesanan</span><span><strong>{{ $pesanan->idPesanan }}</strong></span></div>
        <div class="info-row"><span class="info-label">Tanggal</span><span>{{ \Carbon\Carbon::parse($pesanan->tglPesanan)->format('d M Y H:i') }}</span></div>
        <div class="info-row"><span class="info-label">Metode Pembayaran</span><span>{{ $pesanan->metodePembayaran }}</span></div>
        <div class="info-row"><span class="info-label">Total</span><span><strong style="color:#A8C8E8;">Rp {{ number_format($pesanan->detailPesanans->sum('subtotal'), 0, ',', '.') }}</strong></span></div>
        <div class="info-row"><span class="info-label">Catatan</span><span>{{ $pesanan->catatan ?? '-' }}</span></div>
        <a href="{{ route('invoice', $pesanan->idPesanan) }}" class="btn-invoice">📄 Download Invoice</a>
    </div>

    {{-- TIMELINE --}}
    <div class="timeline-card">
        <h3>🚀 Status Pengiriman</h3>
        @php
            $status = $pesanan->status ?? 'pending';
            $steps = [
                'pending'  => 0,
                'proses'   => 1,
                'selesai'  => 2,
                'batal'    => -1,
            ];
            $currentStep = $steps[$status] ?? 0;
            $isCancelled = $status === 'batal';
        @endphp

        <div class="timeline">
            {{-- STEP 1: Pesanan Diterima --}}
            <div class="timeline-item">
                <div class="timeline-dot {{ $currentStep >= 0 && !$isCancelled ? 'done' : '' }} {{ $isCancelled ? 'cancelled' : '' }}">
                    {{ $isCancelled ? '✕' : '✓' }}
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">{{ $isCancelled ? '❌ Pesanan Dibatalkan' : '✅ Pesanan Diterima' }}</div>
                    <div class="timeline-desc">
                        {{ $isCancelled ? 'Pesanan kamu telah dibatalkan.' : 'Pesanan kamu telah berhasil dibuat dan menunggu konfirmasi.' }}
                    </div>
                    <div class="timeline-time">{{ \Carbon\Carbon::parse($pesanan->tglPesanan)->format('d M Y H:i') }}</div>
                </div>
            </div>

            @if(!$isCancelled)
            {{-- STEP 2: Diproses --}}
            <div class="timeline-item">
                <div class="timeline-dot {{ $currentStep >= 1 ? ($currentStep == 1 ? 'active' : 'done') : '' }}">
                    {{ $currentStep >= 1 ? '✓' : '' }}
                </div>
                <div class="timeline-content">
                    <div class="timeline-title {{ $currentStep < 1 ? 'inactive' : '' }}">🔄 Sedang Diproses</div>
                    <div class="timeline-desc">
                        {{ $currentStep >= 1 ? 'Pesanan kamu sedang diproses oleh tim kami.' : 'Menunggu diproses...' }}
                    </div>
                    @if($currentStep >= 1)
                    <div class="timeline-time">Pesanan sedang disiapkan</div>
                    @endif
                </div>
            </div>

            {{-- STEP 3: Selesai --}}
            <div class="timeline-item">
                <div class="timeline-dot {{ $currentStep >= 2 ? 'done' : '' }}">
                    {{ $currentStep >= 2 ? '✓' : '' }}
                </div>
                <div class="timeline-content">
                    <div class="timeline-title {{ $currentStep < 2 ? 'inactive' : '' }}">🎉 Pesanan Selesai</div>
                    <div class="timeline-desc">
                        {{ $currentStep >= 2 ? 'Pesanan kamu telah selesai. Terima kasih!' : 'Menunggu selesai...' }}
                    </div>
                    @if($currentStep >= 2)
                    <div class="timeline-time">Selesai</div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- ITEM PESANAN --}}
    <div class="info-card">
        <h3>🛒 Item Pesanan</h3>
        @foreach($pesanan->detailPesanans as $detail)
        <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f5f5f5;font-size:14px;">
            <div>
                <div style="font-weight:600;">{{ $detail->namaMenu }}</div>
                <div style="color:#888;font-size:12px;">× {{ $detail->jumlah }}</div>
            </div>
            <div style="font-weight:600;color:#A8C8E8;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
        </div>
        @endforeach
        <div style="display:flex;justify-content:space-between;padding:14px 0 0;font-weight:700;font-size:16px;">
            <span>Total</span>
            <span style="color:#A8C8E8;">Rp {{ number_format($pesanan->detailPesanans->sum('subtotal'), 0, ',', '.') }}</span>
        </div>
    </div>
</div>
@endsection