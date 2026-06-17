@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<style>
    .form-card { background: #fff; border-radius: 16px; padding: 32px; max-width: 560px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); animation: fadeUp 0.4s ease; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-size: 13px; font-weight: 500; color: #555; margin-bottom: 6px; }
    .form-group input, .form-group textarea { width: 100%; padding: 12px 16px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif; transition: border-color 0.2s; background: #fafafa; }
    .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #A8C8E8; background: #fff; }
    .btn-submit { padding: 12px 28px; background: #A8C8E8; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s; }
    .btn-submit:hover { background: #8BB5D9; transform: translateY(-1px); }
    .btn-cancel { margin-left: 12px; color: #888; text-decoration: none; font-size: 14px; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="page-header">
    <h1>Edit Produk</h1>
</div>

<div class="form-card">
    <form action="{{ route('admin.products.update', $product->idProduk) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="namaProduk" value="{{ $product->namaProduk }}" required>
        </div>
        <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" value="{{ $product->harga }}" required>
        </div>
        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" value="{{ $product->stok }}" required>
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori_id" style="width:100%;padding:12px 16px;border:1.5px solid #e8e8e8;border-radius:10px;font-size:14px;font-family:'Inter',sans-serif;background:#fafafa;">
                <option value="">-- Pilih Kategori --</option>
                @foreach(\App\Models\Kategori::all() as $kat)
                <option value="{{ $kat->id }}" {{ isset($product) && $product->kategori_id == $kat->id ? 'selected' : '' }}>
                    {{ $kat->icon }} {{ $kat->nama }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="3">{{ $product->deskripsi }}</textarea>
        </div>
        <div class="form-group">
            <label>Gambar Baru (opsional)</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn-submit">Update Produk</button>
        <a href="{{ route('admin.products.index') }}" class="btn-cancel">Batal</a>
    </form>
</div>
@endsection