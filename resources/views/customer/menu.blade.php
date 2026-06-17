@extends('layouts.customer')
@section('title', 'Menu')
@section('content')
<style>
    .page-header { margin-bottom: 32px; animation: fadeUp 0.4s ease; }
    .page-header h1 { font-family: 'Playfair Display', serif; font-size: 36px; color: #1a1a2e; }
    .page-header p { color: #888; margin-top: 6px; }
    .menu-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
    .menu-card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); transition: transform 0.3s, box-shadow 0.3s; animation: fadeUp 0.5s ease both; }
    .menu-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0,0,0,0.12); }
    .menu-emoji { font-size: 36px; margin-bottom: 12px; }
    .menu-name { font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 6px; }
    .menu-desc { font-size: 13px; color: #888; margin-bottom: 8px; line-height: 1.5; }
    .menu-stock { font-size: 12px; color: #aaa; margin-bottom: 12px; }
    .menu-price { font-size: 20px; font-weight: 700; color: #A8C8E8; margin-bottom: 16px; }
    .btn-add { width: 100%; padding: 10px; background: #A8C8E8; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: 'Inter', sans-serif; }
    .btn-add:hover { background: #8BB5D9; transform: scale(1.02); }
    .btn-login-link { display: block; text-align: center; padding: 10px; background: #EFF6FF; color: #A8C8E8; text-decoration: none; border-radius: 10px; font-size: 14px; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="page-header">
    <h1>Menu Kami</h1>
    <p>Temukan minuman dan makanan favoritmu</p>
</div>

<div class="menu-grid">
    @forelse($menus as $menu)
    <div class="menu-card" style="animation-delay: {{ $loop->index * 0.08 }}s">
        <div class="menu-emoji">☕</div>
        <div class="menu-name">{{ $menu->namaProduk }}</div>
        <div class="menu-desc">{{ $menu->deskripsi ?? '-' }}</div>
        <div class="menu-stock">Stok: {{ $menu->stok }}</div>
        <div class="menu-price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
        @auth
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="idProduk" value="{{ $menu->idProduk }}">
            <button class="btn-add">+ Keranjang</button>
        </form>
        @else
        <a href="{{ route('login') }}" class="btn-login-link">Masuk untuk memesan</a>
        @endauth
    </div>
    @empty
    <p style="color:#888;grid-column:span 3;text-align:center;padding:40px;">Belum ada menu.</p>
    
        {{-- RATING --}}
    @php $rata = round($menu->reviews_avg_rating, 1); @endphp
    <div style="margin:10px 0;font-size:13px;color:#888;">
        <span style="color:#f1c40f;">
            @for($i = 1; $i <= 5; $i++){{ $i <= $rata ? '★' : '☆' }}@endfor
        </span>
        {{ $rata > 0 ? $rata . '/5' : 'Belum ada rating' }}
        ({{ $menu->reviews_count ?? 0 }} ulasan)
    </div>

    {{-- FORM REVIEW --}}
    @auth
    <details style="margin-top:8px;">
        <summary style="font-size:13px;color:#A8C8E8;cursor:pointer;">✏️ Tulis Review</summary>
        <form action="{{ route('review.store') }}" method="POST" style="margin-top:10px;">
            @csrf
            <input type="hidden" name="idProduk" value="{{ $menu->idProduk }}">
            <div style="display:flex;gap:4px;margin-bottom:8px;" id="stars-{{ $menu->idProduk }}">
                @for($i = 1; $i <= 5; $i++)
                <label style="cursor:pointer;font-size:22px;color:#ddd;" class="star-label">
                    <input type="radio" name="rating" value="{{ $i }}" style="display:none;" required>
                    ★
                </label>
                @endfor
            </div>
            <textarea name="komentar" rows="2" placeholder="Tulis komentar..." style="width:100%;padding:8px 12px;border:1.5px solid #e8e8e8;border-radius:8px;font-size:13px;font-family:'Inter',sans-serif;margin-bottom:8px;resize:none;"></textarea>
            <button type="submit" style="padding:7px 18px;background:#A8C8E8;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">Kirim</button>
        </form>
    </details>
    @endauth
    @endforelse
</div>

<script>
document.querySelectorAll('.star-label').forEach((label, idx, labels) => {
    label.addEventListener('mouseover', () => {
        labels.forEach((l, i) => l.style.color = i <= idx ? '#f1c40f' : '#ddd');
    });
    label.addEventListener('click', () => {
        labels.forEach((l, i) => l.style.color = i <= idx ? '#f1c40f' : '#ddd');
    });
    label.closest('form').querySelector('div').addEventListener('mouseleave', () => {
        const checked = label.closest('form').querySelector('input[name="rating"]:checked');
        const val = checked ? parseInt(checked.value) - 1 : -1;
        labels.forEach((l, i) => l.style.color = i <= val ? '#f1c40f' : '#ddd');
    });
});
</script>

@endsection