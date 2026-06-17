@extends('layouts.admin')
@section('title', 'Edit Promo')
@section('content')
<style>
    .form-card { background:#fff; border-radius:16px; padding:32px; max-width:600px; box-shadow:0 2px 12px rgba(0,0,0,0.06); animation:fadeUp 0.4s ease; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:12px; font-weight:600; color:#888; margin-bottom:6px; text-transform:uppercase; }
    .form-group input, .form-group select { width:100%; padding:12px 16px; border:1.5px solid #e8e8e8; border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; background:#fafafa; transition:border-color 0.2s; }
    .form-group input:focus, .form-group select:focus { outline:none; border-color:#A8C8E8; background:#fff; }
    .btn-submit { padding:12px 28px; background:#A8C8E8; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; }
    .btn-cancel { margin-left:12px; color:#888; text-decoration:none; font-size:14px; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-header"><h1>Edit Promo</h1></div>

<div class="form-card">
    <form action="{{ route('admin.promos.update', $promo) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-row">
            <div class="form-group">
                <label>Kode Promo</label>
                <input type="text" value="{{ $promo->kode }}" disabled style="background:#f0f0f0;color:#888;">
            </div>
            <div class="form-group">
                <label>Nama Promo</label>
                <input type="text" name="nama" value="{{ $promo->nama }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Tipe Diskon</label>
                <select name="tipe">
                    <option value="persen" {{ $promo->tipe == 'persen' ? 'selected' : '' }}>Persen (%)</option>
                    <option value="nominal" {{ $promo->tipe == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nilai Diskon</label>
                <input type="number" name="nilai" value="{{ $promo->nilai }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Minimum Belanja (Rp)</label>
                <input type="number" name="min_belanja" value="{{ $promo->min_belanja }}">
            </div>
            <div class="form-group">
                <label>Maksimal Diskon (Rp)</label>
                <input type="number" name="maks_diskon" value="{{ $promo->maks_diskon }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Kuota</label>
                <input type="number" name="kuota" value="{{ $promo->kuota }}">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="is_active">
                    <option value="1" {{ $promo->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$promo->is_active ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" value="{{ $promo->tgl_mulai->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label>Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" value="{{ $promo->tgl_selesai->format('Y-m-d') }}" required>
            </div>
        </div>
        <button type="submit" class="btn-submit">Update Promo</button>
        <a href="{{ route('admin.promos.index') }}" class="btn-cancel">Batal</a>
    </form>
</div>
@endsection