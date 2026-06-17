@extends('layouts.customer')
@section('title', 'Keranjang')
@section('content')
<style>
    .cart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; animation: fadeUp 0.4s ease; }
    .cart-header h1 { font-family: 'Playfair Display', serif; font-size: 32px; }
    .badge-count { background: #A8C8E8; color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; }
    .cart-item { background: #fff; border-radius: 16px; padding: 20px 24px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); animation: fadeUp 0.4s ease both; transition: box-shadow 0.2s; }
    .cart-item:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
    .cart-item-info h3 { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
    .cart-item-info p { font-size: 13px; color: #888; }
    .cart-item-right { display: flex; align-items: center; gap: 20px; }
    .cart-item-qty { font-size: 14px; color: #555; background: #f5f0e8; padding: 6px 14px; border-radius: 20px; }
    .cart-item-price { font-weight: 700; color: #A8C8E8; font-size: 16px; min-width: 100px; text-align: right; }
    .btn-remove { background: none; border: none; color: #ccc; font-size: 18px; cursor: pointer; transition: color 0.2s; }
    .btn-remove:hover { color: #e74c3c; }

    .order-summary { background: #fff; border-radius: 16px; padding: 28px; margin-top: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); animation: fadeUp 0.5s ease; }
    .order-summary h2 { font-family: 'Playfair Display', serif; font-size: 22px; margin-bottom: 20px; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 15px; color: #555; }
    .summary-total { display: flex; justify-content: space-between; margin-top: 16px; padding-top: 16px; border-top: 2px solid #f5f0e8; font-size: 18px; font-weight: 700; }
    .summary-total span:last-child { color: #A8C8E8; background: #A8C8E8; color: #fff; padding: 8px 24px; border-radius: 30px; }

    .btn-checkout { display: block; width: 100%; padding: 16px; background: #A8C8E8; color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; cursor: pointer; margin-top: 20px; font-family: 'Inter', sans-serif; transition: all 0.3s; text-align: center; text-decoration: none; box-shadow: 0 4px 15px rgba(168,200,232,0.3); }
    .btn-checkout:hover { background: #8BB5D9; transform: translateY(-2px); }
    .btn-more { display: block; text-align: center; padding: 14px; border: 2px dashed #B8D4E8; border-radius: 14px; color: #A8C8E8; text-decoration: none; font-size: 14px; margin-top: 12px; transition: all 0.2s; }
    .btn-more:hover { background: #EFF6FF; border-color: #A8C8E8; }
    .empty-cart { text-align: center; padding: 80px 0; animation: fadeUp 0.5s ease; }
    .empty-cart p { color: #888; margin-bottom: 20px; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

@php $cartCount = count($cart); @endphp

<div class="cart-header">
    <h1>Keranjang</h1>
    @if($cartCount > 0)<span class="badge-count">{{ $cartCount }} item</span>@endif
</div>

@if(empty($cart))
<div class="empty-cart">
    <div style="font-size:60px;margin-bottom:16px;">🛒</div>
    <p>Keranjang kamu masih kosong.</p>
    <a href="{{ route('menu') }}" class="btn-checkout" style="display:inline-block;width:auto;padding:14px 32px;">Lihat Menu</a>
</div>
@else
@php $total = 0; @endphp
@foreach($cart as $item)
@php $subtotal = $item['harga'] * $item['jumlah']; $total += $subtotal; @endphp
<div class="cart-item" style="animation-delay: {{ $loop->index * 0.08 }}s">
    <div style="display:flex;align-items:center;gap:16px;">
        <div style="font-size:36px;">☕</div>
        <div class="cart-item-info">
            <h3>{{ $item['namaProduk'] }}</h3>
            <p>Rp {{ number_format($item['harga'], 0, ',', '.') }} / item</p>
        </div>
    </div>
    <div class="cart-item-right">
        <span class="cart-item-qty">× {{ $item['jumlah'] }}</span>
        <span class="cart-item-price">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        <form action="{{ route('cart.remove', $item['idProduk']) }}" method="POST">
            @csrf @method('DELETE')
            <button class="btn-remove" title="Hapus">✕</button>
        </form>
    </div>
</div>
@endforeach

<a href="{{ route('menu') }}" class="btn-more">⊕ Tambah item lagi</a>

{{-- FORM PROMO --}}
@if(session('promo'))
<div style="background:#d4f4e2;border-radius:12px;padding:16px 20px;margin-top:12px;display:flex;justify-content:space-between;align-items:center;">
    <div>
        <span style="font-weight:600;color:#1a6b3c;">🎁 {{ session('promo.kode') }}</span>
        <span style="color:#1a6b3c;font-size:14px;margin-left:8px;">- Rp {{ number_format(session('promo.diskon'), 0, ',', '.') }}</span>
    </div>
    <form action="{{ route('promo.remove') }}" method="POST">
        @csrf @method('DELETE')
        <button style="background:none;border:none;color:#c0392b;cursor:pointer;font-size:13px;">✕ Hapus</button>
    </form>
</div>
@else
<div style="background:#fff;border-radius:12px;padding:16px 20px;margin-top:12px;">
    <form action="{{ route('promo.apply') }}" method="POST" style="display:flex;gap:10px;">
        @csrf
        <input type="text" name="kode" placeholder="Kode promo..." style="flex:1;padding:10px 16px;border:1.5px solid #e8e8e8;border-radius:10px;font-size:14px;font-family:'Inter',sans-serif;" value="{{ old('kode') }}">
        <button type="submit" style="padding:10px 20px;background:#A8C8E8;color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;">Pakai</button>
    </form>
    @error('kode')<div style="color:#e74c3c;font-size:12px;margin-top:6px;">{{ $message }}</div>@enderror
</div>
@endif

<div class="order-summary">
    <h2>Ringkasan Pesanan</h2>
    @php
        $diskon = session('promo.diskon', 0);
        $grandTotal = $total - $diskon;
    @endphp
    <div class="summary-row"><span>Subtotal</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
    @if($diskon > 0)
    <div class="summary-row" style="color:#1a6b3c;"><span>🎁 Diskon</span><span>- Rp {{ number_format($diskon, 0, ',', '.') }}</span></div>
    @endif
    <div class="summary-total"><span>Total</span><span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span></div>
    <a href="{{ route('checkout.index') }}" class="btn-checkout">Lanjut ke Pembayaran →</a>
</div>
@endif
@endsection