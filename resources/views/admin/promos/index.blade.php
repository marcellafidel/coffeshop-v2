@extends('layouts.admin')
@section('title', 'Promo')
@section('content')
<style>
    .page-actions { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
    .btn-add { padding:10px 22px; background:#A8C8E8; color:#fff; text-decoration:none; border-radius:10px; font-size:14px; font-weight:600; transition:all 0.2s; }
    .btn-add:hover { background:#8BB5D9; }
    .table-card { background:#fff; border-radius:16px; padding:24px; box-shadow:0 2px 12px rgba(0,0,0,0.06); animation:fadeUp 0.4s ease; }
    table { width:100%; border-collapse:collapse; }
    th { padding:10px 14px; text-align:left; font-size:12px; color:#888; text-transform:uppercase; border-bottom:2px solid #f0f0f0; }
    td { padding:12px 14px; font-size:14px; border-bottom:1px solid #f5f5f5; }
    tr:last-child td { border-bottom:none; }
    .badge-active { background:#d4f4e2; color:#1a6b3c; padding:4px 12px; border-radius:20px; font-size:12px; }
    .badge-inactive { background:#fde8e8; color:#c0392b; padding:4px 12px; border-radius:20px; font-size:12px; }
    .btn-edit { padding:5px 12px; background:#EFF6FF; color:#A8C8E8; border-radius:6px; text-decoration:none; font-size:12px; font-weight:600; }
    .btn-delete { padding:5px 12px; background:#fde8e8; color:#e74c3c; border-radius:6px; border:none; font-size:12px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-actions">
    <div class="page-header" style="margin-bottom:0;">
        <h1>Promo & Diskon</h1>
        <p>Kelola kode promo</p>
    </div>
    <a href="{{ route('admin.promos.create') }}" class="btn-add">+ Tambah Promo</a>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Diskon</th>
                <th>Min. Belanja</th>
                <th>Kuota</th>
                <th>Berlaku</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promos as $promo)
            <tr>
                <td><strong>{{ $promo->kode }}</strong></td>
                <td>{{ $promo->nama }}</td>
                <td>
                    @if($promo->tipe == 'persen')
                        {{ $promo->nilai }}%
                    @else
                        Rp {{ number_format($promo->nilai, 0, ',', '.') }}
                    @endif
                </td>
                <td>Rp {{ number_format($promo->min_belanja, 0, ',', '.') }}</td>
                <td>{{ $promo->kuota ? $promo->terpakai.'/'.$promo->kuota : '∞' }}</td>
                <td style="font-size:12px;">{{ $promo->tgl_mulai->format('d M') }} - {{ $promo->tgl_selesai->format('d M Y') }}</td>
                <td>
                    @if($promo->isValid())
                        <span class="badge-active">Aktif</span>
                    @else
                        <span class="badge-inactive">Nonaktif</span>
                    @endif
                </td>
                <td style="display:flex;gap:8px;">
                    <a href="{{ route('admin.promos.edit', $promo) }}" class="btn-edit">Edit</a>
                    <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn-delete" onclick="return confirm('Hapus promo ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#888;padding:24px;">Belum ada promo.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:16px;">{{ $promos->links() }}</div>
</div>
@endsection