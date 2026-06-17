@extends('layouts.admin')
@section('title', 'Kategori')
@section('content')
<style>
    .page-actions { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
    .btn-add { padding:10px 22px; background:#A8C8E8; color:#fff; text-decoration:none; border-radius:10px; font-size:14px; font-weight:600; transition:all 0.2s; }
    .btn-add:hover { background:#8BB5D9; }
    .kategori-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; animation:fadeUp 0.4s ease; }
    .kategori-card { background:#fff; border-radius:14px; padding:22px; box-shadow:0 2px 10px rgba(0,0,0,0.05); display:flex; justify-content:space-between; align-items:center; transition:all 0.2s; }
    .kategori-card:hover { box-shadow:0 6px 20px rgba(0,0,0,0.1); transform:translateY(-2px); }
    .kategori-icon { font-size:32px; margin-bottom:4px; }
    .kategori-name { font-family:'Playfair Display',serif; font-size:16px; }
    .kategori-count { font-size:12px; color:#aaa; }
    .btn-edit { padding:5px 12px; background:#EFF6FF; color:#A8C8E8; border-radius:6px; text-decoration:none; font-size:12px; font-weight:600; }
    .btn-delete { padding:5px 12px; background:#fde8e8; color:#e74c3c; border-radius:6px; border:none; font-size:12px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-actions">
    <div class="page-header" style="margin-bottom:0;">
        <h1>Kategori Menu</h1>
        <p>Kelola kategori produk</p>
    </div>
    <a href="{{ route('admin.kategoris.create') }}" class="btn-add">+ Tambah Kategori</a>
</div>

<div class="kategori-grid">
    @forelse($kategoris as $kategori)
    <div class="kategori-card">
        <div>
            <div class="kategori-icon">{{ $kategori->icon }}</div>
            <div class="kategori-name">{{ $kategori->nama }}</div>
            <div class="kategori-count">{{ $kategori->menus_count }} produk</div>
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;">
            <a href="{{ route('admin.kategoris.edit', $kategori) }}" class="btn-edit">Edit</a>
            <form action="{{ route('admin.kategoris.destroy', $kategori) }}" method="POST">
                @csrf @method('DELETE')
                <button class="btn-delete" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <p style="color:#888;grid-column:span 3;text-align:center;padding:40px;">Belum ada kategori.</p>
    @endforelse
</div>
<div style="margin-top:16px;">{{ $kategoris->links() }}</div>
@endsection