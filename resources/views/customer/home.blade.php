@extends('layouts.customer')
@section('title', 'Home')
@section('content')
<style>
    .hero { text-align: center; padding: 80px 0 60px; animation: fadeUp 0.6s ease; }
    .hero h1 { font-family: 'Playfair Display', serif; font-size: 52px; color: #1a1a2e; line-height: 1.2; margin-bottom: 16px; }
    .hero p { font-size: 18px; color: #777; margin-bottom: 32px; }
    .btn-primary { display: inline-block; padding: 14px 36px; background: #A8C8E8; color: #fff; text-decoration: none; border-radius: 30px; font-weight: 600; font-size: 15px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(168,200,232,0.3); }
    .btn-primary:hover { background: #8BB5D9; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(168,200,232,0.4); }

    .section-title { font-family: 'Playfair Display', serif; font-size: 28px; margin-bottom: 24px; color: #1a1a2e; }
    .menu-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }

    .menu-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: transform 0.3s, box-shadow 0.3s;
        animation: fadeUp 0.5s ease both;
    }
    .menu-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0,0,0,0.12); }
    .menu-card:nth-child(1) { animation-delay: 0.1s; }
    .menu-card:nth-child(2) { animation-delay: 0.2s; }
    .menu-card:nth-child(3) { animation-delay: 0.3s; }
    .menu-card:nth-child(4) { animation-delay: 0.4s; }
    .menu-card:nth-child(5) { animation-delay: 0.5s; }
    .menu-card:nth-child(6) { animation-delay: 0.6s; }

    .menu-emoji { font-size: 40px; margin-bottom: 12px; }
    .menu-name { font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 6px; }
    .menu-desc { font-size: 13px; color: #888; margin-bottom: 12px; line-height: 1.5; }
    .menu-price { font-size: 18px; font-weight: 700; color: #A8C8E8; margin-bottom: 16px; }
    .btn-add {
        width: 100%; padding: 10px; background: #A8C8E8; color: #fff;
        border: none; border-radius: 10px; font-size: 14px; font-weight: 600;
        cursor: pointer; transition: all 0.2s; font-family: 'Inter', sans-serif;
    }
    .btn-add:hover { background: #8BB5D9; transform: scale(1.02); }
    .btn-login-link { display: block; text-align: center; padding: 10px; background: #EFF6FF; color: #A8C8E8; text-decoration: none; border-radius: 10px; font-size: 14px; font-weight: 500; transition: background 0.2s; }
    .btn-login-link:hover { background: #D6EAF8; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="hero">
    <h1>Kopi Terbaik,<br>Setiap Hari ☕</h1>
    <p>Nikmati cita rasa premium dari biji kopi pilihan kami</p>
    <a href="{{ route('menu') }}" class="btn-primary">Lihat Semua Menu →</a>
</div>

<h2 class="section-title">Menu Unggulan</h2>
<div class="menu-grid">
    @forelse($menus as $menu)
    <div class="menu-card">
        <div class="menu-emoji">☕</div>
        <div class="menu-name">{{ $menu->namaProduk }}</div>
        <div class="menu-desc">{{ $menu->deskripsi ?? 'Minuman kopi pilihan terbaik kami.' }}</div>
        <div class="menu-price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
        @auth
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="idProduk" value="{{ $menu->idProduk }}">
            <button class="btn-add">+ Tambah ke Keranjang</button>
        </form>
        @else
        <a href="{{ route('login') }}" class="btn-login-link">Masuk untuk memesan</a>
        @endauth
    </div>
    @empty
    <p style="color:#888;grid-column:span 3;text-align:center;padding:40px;">Belum ada menu tersedia.</p>
    @endforelse
</div>
@endsection