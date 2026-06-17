@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<style>
    .page-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .btn-add { padding: 10px 22px; background: #A8C8E8; color: #fff; text-decoration: none; border-radius: 10px; font-size: 14px; font-weight: 600; transition: all 0.2s; }
    .btn-add:hover { background: #8BB5D9; transform: translateY(-1px); }
    .table-card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); animation: fadeUp 0.4s ease; }
    table { width: 100%; border-collapse: collapse; }
    th { padding: 10px 14px; text-align: left; font-size: 12px; color: #888; text-transform: uppercase; border-bottom: 2px solid #f0f0f0; }
    td { padding: 12px 14px; font-size: 14px; border-bottom: 1px solid #f5f5f5; }
    tr:last-child td { border-bottom: none; }
    .btn-edit { padding: 5px 12px; background: #EFF6FF; color: #A8C8E8; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; }
    .btn-delete { padding: 5px 12px; background: #fde8e8; color: #e74c3c; border-radius: 6px; border: none; font-size: 12px; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="page-actions">
    <div class="page-header" style="margin-bottom:0;">
        <h1>Produk</h1>
        <p>Kelola menu coffeshop</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-add">+ Tambah Produk</a>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->namaProduk }}</td>
                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                <td>{{ $product->stok }}</td>
                <td style="display:flex;gap:8px;">
                    <a href="{{ route('admin.products.edit', $product->idProduk) }}" class="btn-edit">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->idProduk) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn-delete" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:#888;padding:24px;">Belum ada produk.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:16px;">{{ $products->links() }}</div>
</div>
@endsection