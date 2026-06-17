@extends('layouts.admin')
@section('title', 'Tambah Kategori')
@section('content')
<style>
    .form-card { background:#fff; border-radius:16px; padding:32px; max-width:480px; box-shadow:0 2px 12px rgba(0,0,0,0.06); animation:fadeUp 0.4s ease; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:12px; font-weight:600; color:#888; margin-bottom:6px; text-transform:uppercase; }
    .form-group input, .form-group textarea { width:100%; padding:12px 16px; border:1.5px solid #e8e8e8; border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; background:#fafafa; transition:border-color 0.2s; }
    .form-group input:focus, .form-group textarea:focus { outline:none; border-color:#A8C8E8; background:#fff; }
    .btn-submit { padding:12px 28px; background:#A8C8E8; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; }
    .btn-cancel { margin-left:12px; color:#888; text-decoration:none; font-size:14px; }
    .icon-preview { font-size:40px; text-align:center; margin-bottom:8px; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-header"><h1>Tambah Kategori</h1></div>

<div class="form-card">
    <form action="{{ route('admin.kategoris.store') }}" method="POST">
        @csrf
        <div class="icon-preview" id="iconPreview">☕</div>
        <div class="form-group">
            <label>Icon (Emoji)</label>
            <input type="text" name="icon" id="iconInput" placeholder="☕" maxlength="4" value="☕" oninput="document.getElementById('iconPreview').textContent = this.value || '☕'">
        </div>
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="nama" placeholder="Contoh: Kopi, Teh, Makanan" required>
        </div>
        <div class="form-group">
            <label>Deskripsi (opsional)</label>
            <textarea name="deskripsi" rows="2" placeholder="Deskripsi singkat kategori..."></textarea>
        </div>
        <button type="submit" class="btn-submit">Simpan</button>
        <a href="{{ route('admin.kategoris.index') }}" class="btn-cancel">Batal</a>
    </form>
</div>
@endsection