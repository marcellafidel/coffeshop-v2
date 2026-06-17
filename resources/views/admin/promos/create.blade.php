@extends('layouts.admin')
@section('title', 'Tambah Promo')
@section('content')
<style>
    .form-card { background:#fff; border-radius:16px; padding:32px; max-width:600px; box-shadow:0 2px 12px rgba(0,0,0,0.06); animation:fadeUp 0.4s ease; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:12px; font-weight:600; color:#888; margin-bottom:6px; text-transform:uppercase; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:12px 16px; border:1.5px solid #e8e8e8; border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; background:#fafafa; transition:border-color 0.2s; }
    .form-group input:focus, .form-group select:focus { outline:none; border-color:#A8C8E8; background:#fff; }
    .btn-submit { padding:12px 28px; background:#A8C8E8; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
    .btn-submit:hover { background:#8BB5D9; }
    .btn-cancel { margin-left:12px; color:#888; text-decoration:none; font-size:14px; }
    .hint { font-size:11px; color:#aaa; margin-top:4px; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-header"><h1>Tambah Promo</h1></div>

<div class="form-card">
    <form action="{{ route('admin.promos.store') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label>Kode Promo</label>
                <input type="text" name="kode" placeholder="KOPI10" style="text-transform:uppercase;" required>
                <div class="hint">Kode unik, huruf kapital</div>
            </div>
            <div class="form-group">
                <label>Nama Promo</label>
                <input type="text" name="nama" placeholder="Diskon 10% Kopi" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Tipe Diskon</label>
                <select name="tipe" required>
                    <option value="persen">Persen (%)</option>
                    <option value="nominal">Nominal (Rp)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nilai Diskon</label>
                <input type="number" name="nilai" placeholder="10" required>
                <div class="hint">Isi angka saja (10 = 10% atau Rp 10.000)</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Minimum Belanja (Rp)</label>
                <input type="number" name="min_belanja" placeholder="50000" value="0">
            </div>
            <div class="form-group">
                <label>Maksimal Diskon (Rp)</label>
                <input type="number" name="maks_diskon" placeholder="Kosongkan jika tidak ada batas">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Kuota</label>
                <input type="number" name="kuota" placeholder="Kosongkan jika tidak terbatas">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" name="deskripsi" placeholder="Deskripsi singkat promo">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" required>
            </div>
            <div class="form-group">
                <label>Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" required>
            </div>
        </div>
        <button type="submit" class="btn-submit">Simpan Promo</button>
        <a href="{{ route('admin.promos.index') }}" class="btn-cancel">Batal</a>
    </form>
</div>
@endsection