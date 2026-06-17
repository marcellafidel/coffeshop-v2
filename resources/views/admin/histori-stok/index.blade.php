@extends('layouts.admin')

@section('title', 'Histori Stok')

@section('content')
<style>
    .table-card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); animation: fadeUp 0.4s ease; }
    table { width: 100%; border-collapse: collapse; }
    th { padding: 10px 14px; text-align: left; font-size: 12px; color: #888; text-transform: uppercase; border-bottom: 2px solid #f0f0f0; }
    td { padding: 12px 14px; font-size: 14px; border-bottom: 1px solid #f5f5f5; }
    tr:last-child td { border-bottom: none; }
    .badge-masuk { padding: 4px 12px; border-radius: 20px; font-size: 12px; background: #d4f4e2; color: #1a6b3c; }
    .badge-keluar { padding: 4px 12px; border-radius: 20px; font-size: 12px; background: #fde8e8; color: #c0392b; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="page-header">
    <h1>Histori Stok</h1>
    <p>Riwayat penjualan dan restok produk</p>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Jenis</th>
                <th>Stok Sebelum</th>
                <th>Perubahan</th>
                <th>Stok Sesudah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histori as $h)
            <tr>
                <td>{{ $h->created_at ? $h->created_at->format('d M Y H:i') : '-' }}</td>
                <td>{{ $h->menu->namaProduk ?? $h->namaProduk }}</td>
                <td>
                    @if($h->jenis_perubahan == 'masuk')
                        <span class="badge-masuk">↑ Restok</span>
                    @else
                        <span class="badge-keluar">↓ Terjual</span>
                    @endif
                </td>
                <td>{{ $h->stok_sebelum }}</td>
                <td style="font-weight:600;color:{{ $h->jenis_perubahan == 'masuk' ? '#1a6b3c' : '#c0392b' }}">
                    {{ $h->jenis_perubahan == 'masuk' ? '+' : '-' }}{{ abs($h->perubahan) }}
                </td>
                <td>{{ $h->stok_sesudah }}</td>
                <td style="color:#888;">{{ $h->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#888;padding:24px;">Belum ada histori stok.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:16px;">{{ $histori->links() }}</div>
</div>
@endsection