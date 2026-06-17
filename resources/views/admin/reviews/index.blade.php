@extends('layouts.admin')
@section('title', 'Review Produk')
@section('content')
<style>
    .table-card { background:#fff; border-radius:16px; padding:24px; box-shadow:0 2px 12px rgba(0,0,0,0.06); animation:fadeUp 0.4s ease; }
    table { width:100%; border-collapse:collapse; }
    th { padding:10px 14px; text-align:left; font-size:12px; color:#888; text-transform:uppercase; border-bottom:2px solid #f0f0f0; }
    td { padding:12px 14px; font-size:14px; border-bottom:1px solid #f5f5f5; }
    tr:last-child td { border-bottom:none; }
    .stars { color:#f1c40f; font-size:16px; }
    .btn-delete { padding:5px 12px; background:#fde8e8; color:#e74c3c; border-radius:6px; border:none; font-size:12px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-header">
    <h1>Review Produk</h1>
    <p>Semua ulasan dari customer</p>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Customer</th>
                <th>Produk</th>
                <th>Rating</th>
                <th>Komentar</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
            <tr>
                <td>{{ $review->user->name ?? '-' }}</td>
                <td>{{ $review->menu->namaProduk ?? '-' }}</td>
                <td>
                    <span class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </span>
                </td>
                <td style="color:#888;max-width:200px;">{{ $review->komentar ?? '-' }}</td>
                <td style="font-size:12px;color:#aaa;">{{ $review->created_at->format('d M Y') }}</td>
                <td>
                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn-delete" onclick="return confirm('Hapus review ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#888;padding:24px;">Belum ada review.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:16px;">{{ $reviews->links() }}</div>
</div>
@endsection