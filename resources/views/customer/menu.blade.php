@extends('layouts.customer')
@section('title', 'Menu')
@section('content')
<style>
    .page-header { margin-bottom:24px; animation:fadeUp 0.4s ease; }
    .page-header h1 { font-family:'Playfair Display',serif; font-size:36px; color:#1a1a2e; }
    .page-header p { color:#888; margin-top:6px; }

    .filter-bar { background:#fff; border-radius:16px; padding:20px 24px; box-shadow:0 2px 12px rgba(0,0,0,0.06); margin-bottom:28px; animation:fadeUp 0.4s ease; }
    .filter-bar form { display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; }
    .filter-group { display:flex; flex-direction:column; gap:6px; }
    .filter-group label { font-size:11px; font-weight:600; color:#888; text-transform:uppercase; }
    .filter-group input, .filter-group select { padding:10px 14px; border:1.5px solid #e8e8e8; border-radius:10px; font-size:14px; font-family:'Inter',sans-serif; background:#fafafa; transition:border-color 0.2s; }
    .filter-group input:focus, .filter-group select:focus { outline:none; border-color:#A8C8E8; }
    .search-input { min-width:220px; }
    .btn-filter { padding:10px 22px; background:#A8C8E8; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:all 0.2s; }
    .btn-filter:hover { background:#8BB5D9; }
    .btn-reset { padding:10px 16px; background:#f5f5f5; color:#888; border:none; border-radius:10px; font-size:14px; cursor:pointer; font-family:'Inter',sans-serif; text-decoration:none; transition:all 0.2s; }
    .btn-reset:hover { background:#e8e8e8; }

    .result-info { font-size:14px; color:#888; margin-bottom:16px; }
    .menu-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    .menu-card { background:#fff; border-radius:16px; padding:24px; box-shadow:0 2px 12px rgba(0,0,0,0.06); transition:transform 0.3s,box-shadow 0.3s; animation:fadeUp 0.5s ease both; }
    .menu-card:hover { transform:translateY(-6px); box-shadow:0 12px 30px rgba(0,0,0,0.12); }
    .menu-emoji { font-size:36px; margin-bottom:12px; }
    .menu-kategori { font-size:11px; color:#A8C8E8; font-weight:600; text-transform:uppercase; margin-bottom:4px; }
    .menu-name { font-family:'Playfair Display',serif; font-size:18px; margin-bottom:6px; }
    .menu-desc { font-size:13px; color:#888; margin-bottom:8px; line-height:1.5; }
    .menu-stock { font-size:12px; color:#aaa; margin-bottom:12px; }
    .menu-price { font-size:20px; font-weight:700; color:#A8C8E8; margin-bottom:8px; }
    .menu-rating { font-size:13px; color:#888; margin-bottom:12px; }
    .stars { color:#f1c40f; }
    .btn-add { width:100%; padding:10px; background:#A8C8E8; color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; font-family:'Inter',sans-serif; }
    .btn-add:hover { background:#8BB5D9; transform:scale(1.02); }
    .btn-login-link { display:block; text-align:center; padding:10px; background:#EFF6FF; color:#A8C8E8; text-decoration:none; border-radius:10px; font-size:14px; }

    .empty-state { text-align:center; padding:80px 0; grid-column:span 3; }
    .empty-state p { color:#888; margin-top:12px; }

    @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-header">
    <h1>Menu Kami</h1>
    <p>Temukan minuman dan makanan favoritmu</p>
</div>

{{-- FILTER BAR --}}
<div class="filter-bar">
    <form method="GET" action="{{ route('menu') }}">
        <div class="filter-group">
            <label>Cari</label>
            <input type="text" name="search" class="search-input" placeholder="Cari menu..." value="{{ request('search') }}">
        </div>
        <div class="filter-group">
            <label>Kategori</label>
            <select name="kategori_id">
                <option value="">Semua</option>
                @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                    {{ $kat->icon }} {{ $kat->nama }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>Harga Min</label>
            <input type="number" name="harga_min" placeholder="0" value="{{ request('harga_min') }}" style="width:110px;">
        </div>
        <div class="filter-group">
            <label>Harga Max</label>
            <input type="number" name="harga_max" placeholder="500000" value="{{ request('harga_max') }}" style="width:110px;">
        </div>
        <div class="filter-group">
            <label>Urutkan</label>
            <select name="sort">
                <option value="">Terbaru</option>
                <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga Termurah</option>
                <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga Termahal</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
            </select>
        </div>
        <button type="submit" class="btn-filter">🔍 Cari</button>
        <a href="{{ route('menu') }}" class="btn-reset">Reset</a>
    </form>
</div>

{{-- RESULT INFO --}}
<div class="result-info">
    Menampilkan <strong>{{ $menus->total() }}</strong> menu
    @if(request('search')) untuk "<strong>{{ request('search') }}</strong>" @endif
    @if(request('kategori_id')) dalam kategori <strong>{{ $kategoris->find(request('kategori_id'))?->nama }}</strong> @endif
</div>

{{-- MENU GRID --}}
<div class="menu-grid">
    @forelse($menus as $menu)
    <div class="menu-card" style="animation-delay:{{ $loop->index * 0.06 }}s">
        <div class="menu-emoji">{{ $menu->kategori?->icon ?? '☕' }}</div>
        @if($menu->kategori)
        <div class="menu-kategori">{{ $menu->kategori->nama }}</div>
        @endif
        <div class="menu-name">{{ $menu->namaProduk }}</div>
        <div class="menu-desc">{{ $menu->deskripsi ?? '-' }}</div>
        <div class="menu-stock">Stok: {{ $menu->stok }}</div>
        <div class="menu-price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
        @php $rata = round($menu->reviews_avg_rating, 1); @endphp
        <div class="menu-rating">
            <span class="stars">@for($i=1;$i<=5;$i++){{ $i<=$rata?'★':'☆' }}@endfor</span>
            {{ $rata > 0 ? $rata.'/5' : 'Belum ada rating' }}
            ({{ $menu->reviews_count }} ulasan)
        </div>
        @auth
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="idProduk" value="{{ $menu->idProduk }}">
            <button class="btn-add">+ Keranjang</button>
        </form>
        @else
        <a href="{{ route('login') }}" class="btn-login-link">Masuk untuk memesan</a>
        @endauth

        {{-- FORM REVIEW --}}
        @auth
        <details style="margin-top:12px;">
            <summary style="font-size:13px;color:#A8C8E8;cursor:pointer;">✏️ Tulis Review</summary>
            <form action="{{ route('review.store') }}" method="POST" style="margin-top:10px;">
                @csrf
                <input type="hidden" name="idProduk" value="{{ $menu->idProduk }}">
                <div style="display:flex;gap:4px;margin-bottom:8px;">
                    @for($i=1;$i<=5;$i++)
                    <label style="cursor:pointer;font-size:22px;color:#ddd;" class="star-label">
                        <input type="radio" name="rating" value="{{ $i }}" style="display:none;" required>★
                    </label>
                    @endfor
                </div>
                <textarea name="komentar" rows="2" placeholder="Tulis komentar..." style="width:100%;padding:8px 12px;border:1.5px solid #e8e8e8;border-radius:8px;font-size:13px;font-family:'Inter',sans-serif;margin-bottom:8px;resize:none;"></textarea>
                <button type="submit" style="padding:7px 18px;background:#A8C8E8;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">Kirim</button>
            </form>
        </details>
        @endauth
    </div>
    @empty
    <div class="empty-state">
        <div style="font-size:48px;">🔍</div>
        <p>Tidak ada menu yang sesuai pencarian.</p>
        <a href="{{ route('menu') }}" style="color:#A8C8E8;">Reset filter</a>
    </div>
    @endforelse
</div>

{{-- PAGINATION --}}
<div style="margin-top:32px;display:flex;justify-content:center;">
    {{ $menus->links() }}
</div>

<script>
document.querySelectorAll('.star-label').forEach((label, idx, labels) => {
    label.addEventListener('mouseover', () => labels.forEach((l,i) => l.style.color = i<=idx?'#f1c40f':'#ddd'));
    label.addEventListener('click', () => labels.forEach((l,i) => l.style.color = i<=idx?'#f1c40f':'#ddd'));
    label.closest('form').querySelector('div').addEventListener('mouseleave', () => {
        const checked = label.closest('form').querySelector('input[name="rating"]:checked');
        const val = checked ? parseInt(checked.value)-1 : -1;
        labels.forEach((l,i) => l.style.color = i<=val?'#f1c40f':'#ddd');
    });
});
</script>
@endsection