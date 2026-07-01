@extends('layouts.customer')
@section('title', 'Checkout')
@section('content')
<style>
    .checkout-wrap { max-width: 560px; margin: 0 auto; animation: fadeUp 0.5s ease; }
    .checkout-wrap h1 { font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 28px; }
    .form-card { background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 20px; }
    .form-card h3 { font-size: 16px; font-weight: 600; margin-bottom: 16px; color: #1a1a2e; }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: 500; color: #555; margin-bottom: 6px; }
    .form-group select, .form-group textarea {
        width: 100%; padding: 12px 16px; border: 1.5px solid #e8e8e8;
        border-radius: 10px; font-size: 14px; font-family: 'Inter', sans-serif;
        transition: border-color 0.2s; background: #fafafa; color: #1a1a2e;
    }
    .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #A8C8E8; background: #fff; }
    .btn-order { width: 100%; padding: 16px; background: #A8C8E8; color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.3s; box-shadow: 0 4px 15px rgba(168,200,232,0.3); }
    .btn-order:hover { background: #8BB5D9; transform: translateY(-2px); }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="checkout-wrap">
    <h1>Checkout</h1>
    <form method="POST" action="{{ route('checkout.process') }}">
    @csrf
        <div class="form-card">
            <h3>Metode Pembayaran</h3>
            <div class="form-group">
                <label>Pilih metode</label>
                <select name="metodePembayaran">
                    <option value="transfer">🏦 Transfer Bank</option>
                    <option value="ewallet">📱 E-Wallet</option>
                    <option value="cod">🚚 COD (Bayar di Tempat)</option>
                </select>
            </div>
        </div>
        <div class="form-card">
            <h3>Catatan (opsional)</h3>
            <div class="form-group">
                <label>Pesan untuk penjual</label>
                <textarea name="catatan" rows="3" placeholder="Contoh: tanpa gula, extra shot..."></textarea>
            </div>
        </div>
        <button type="submit" class="btn-order">Buat Pesanan ☕</button>
    </form>
</div>
@endsection