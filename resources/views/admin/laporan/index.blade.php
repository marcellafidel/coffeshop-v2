@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
<style>
    .filter-card { background:#fff; border-radius:16px; padding:20px 24px; box-shadow:0 2px 12px rgba(0,0,0,0.06); margin-bottom:24px; display:flex; gap:16px; align-items:flex-end; animation:fadeUp 0.3s ease; }
    .filter-group label { display:block; font-size:12px; color:#888; margin-bottom:6px; }
    .filter-group select { padding:10px 16px; border:1.5px solid #e8e8e8; border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; }
    .btn-filter { padding:10px 24px; background:#A8C8E8; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
    .btn-filter:hover { background:#8BB5D9; }

    .stat-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:24px; }
    .stat-card { background:#fff; border-radius:16px; padding:24px; box-shadow:0 2px 12px rgba(0,0,0,0.06); animation:fadeUp 0.4s ease both; }
    .stat-label { font-size:12px; color:#888; margin-bottom:8px; text-transform:uppercase; }
    .stat-value { font-family:'Playfair Display',serif; font-size:32px; color:#A8C8E8; }
    .stat-sub { font-size:12px; color:#aaa; margin-top:4px; }

    .table-card { background:#fff; border-radius:16px; padding:24px; box-shadow:0 2px 12px rgba(0,0,0,0.06); margin-bottom:24px; animation:fadeUp 0.5s ease; }
    .table-card h3 { font-family:'Playfair Display',serif; font-size:18px; margin-bottom:16px; }
    table { width:100%; border-collapse:collapse; }
    th { padding:10px 14px; text-align:left; font-size:12px; color:#888; text-transform:uppercase; border-bottom:2px solid #f0f0f0; }
    td { padding:12px 14px; font-size:14px; border-bottom:1px solid #f5f5f5; }
    tr:last-child td { border-bottom:none; }

    .chart-bar-wrap { display:flex; flex-direction:column; gap:8px; }
    .chart-bar-row { display:flex; align-items:center; gap:12px; font-size:13px; }
    .chart-bar-label { min-width:60px; color:#888; text-align:right; }
    .chart-bar-track { flex:1; background:#f0f0f0; border-radius:20px; height:24px; overflow:hidden; }
    .chart-bar-fill { height:100%; background:linear-gradient(90deg,#A8C8E8,#8BB5D9); border-radius:20px; transition:width 1s ease; display:flex; align-items:center; padding-left:10px; font-size:11px; color:#fff; font-weight:600; }
    .chart-bar-value { min-width:100px; color:#555; font-size:12px; }

    .rank-badge { display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; border-radius:50%; background:#EFF6FF; color:#A8C8E8; font-size:12px; font-weight:700; }
    .rank-badge.gold { background:#fff3cd; color:#d4a017; }
    .rank-badge.silver { background:#f0f0f0; color:#888; }
    .rank-badge.bronze { background:#fde8d8; color:#c0602b; }

    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-header">
    <h1>Laporan Keuangan</h1>
    <p>Ringkasan pendapatan dan penjualan</p>
</div>

{{-- FILTER --}}
<div class="filter-card">
    <form method="GET" action="{{ route('admin.laporan.index') }}" style="display:flex;gap:16px;align-items:flex-end;flex-wrap:wrap;">
        <div class="filter-group">
            <label>Bulan</label>
            <select name="bulan">
                @foreach($bulanList as $num => $nama)
                <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>Tahun</label>
            <select name="tahun">
                @foreach(range(now()->year, now()->year - 3) as $y)
                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-filter">Tampilkan</button>
    </form>
</div>

{{-- STAT CARDS --}}
<div class="stat-grid">
    <div class="stat-card" style="animation-delay:0.1s">
        <div class="stat-label">Total Pendapatan</div>
        <div class="stat-value" style="font-size:24px;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        <div class="stat-sub">{{ $bulanList[$bulan] }} {{ $tahun }}</div>
    </div>
    <div class="stat-card" style="animation-delay:0.2s">
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-value">{{ $totalPesanan }}</div>
        <div class="stat-sub">pesanan masuk</div>
    </div>
    <div class="stat-card" style="animation-delay:0.3s">
        <div class="stat-label">Rata-rata per Pesanan</div>
        <div class="stat-value" style="font-size:24px;">
            Rp {{ $totalPesanan > 0 ? number_format($totalPendapatan / $totalPesanan, 0, ',', '.') : '0' }}
        </div>
        <div class="stat-sub">per transaksi</div>
    </div>
</div>

{{-- GRAFIK PER HARI --}}
<div class="table-card">
    <h3>📈 Pendapatan per Hari</h3>
    @if($perHari->isEmpty())
        <p style="color:#888;text-align:center;padding:24px;">Tidak ada data untuk periode ini.</p>
    @else
    @php $maxVal = $perHari->max() ?: 1; @endphp
    <div class="chart-bar-wrap">
        @foreach($perHari as $tgl => $nilai)
        <div class="chart-bar-row">
            <span class="chart-bar-label">{{ $tgl }}</span>
            <div class="chart-bar-track">
                <div class="chart-bar-fill" style="width:{{ ($nilai / $maxVal) * 100 }}%">
                    {{ $nilai > 0 ? 'Rp ' . number_format($nilai/1000, 0) . 'k' : '' }}
                </div>
            </div>
            <span class="chart-bar-value">Rp {{ number_format($nilai, 0, ',', '.') }}</span>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- PRODUK TERLARIS --}}
<div class="table-card">
    <h3>🏆 Produk Terlaris</h3>
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
                <td>
                    <span class="rank-badge {{ $i == 0 ? 'gold' : ($i == 1 ? 'silver' : ($i == 2 ? 'bronze' : '')) }}">
                        {{ $i + 1 }}
                    </span>
                </td>
                <td>{{ $produk->namaMenu }}</td>
                <td>{{ $produk->total_terjual }} pcs</td>
                <td>Rp {{ number_format($produk->total_pendapatan, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:#888;padding:24px;">Belum ada data penjualan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- DETAIL PESANAN --}}
<div class="table-card">
    <h3>📋 Detail Semua Pesanan</h3>
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
                <td><span style="background:#EFF6FF;color:#A8C8E8;padding:4px 12px;border-radius:20px;font-size:12px;">{{ $p->status ?? 'pending' }}</span></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#888;padding:24px;">Tidak ada pesanan bulan ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 