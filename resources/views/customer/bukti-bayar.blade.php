@extends('layouts.customer')
@section('title', 'Upload Bukti Bayar')
@section('content')
<style>
    .bukti-wrap { max-width: 520px; margin: 0 auto; animation: fadeUp 0.5s ease; }
    .bukti-wrap h1 { font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 8px; }
    .bukti-wrap p.sub { color: #777; font-size: 14px; margin-bottom: 28px; }
    .form-card { background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 20px; }
    .form-card h3 { font-size: 15px; font-weight: 600; margin-bottom: 16px; color: #1a1a2e; }
    .info-row { display: flex; justify-content: space-between; font-size: 14px; padding: 8px 0; border-bottom: 1px solid #f0f0f0; }
    .info-row:last-child { border-bottom: none; }
    .info-row span:first-child { color: #777; }
    .info-row span:last-child { font-weight: 600; color: #1a1a2e; }
    .rekening-box { background: #f0f7ff; border: 1.5px solid #A8C8E8; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; }
    .rekening-box p { font-size: 13px; color: #555; margin-bottom: 4px; }
    .rekening-box strong { font-size: 18px; color: #1a1a2e; letter-spacing: 1px; }
    .upload-area { border: 2px dashed #A8C8E8; border-radius: 12px; padding: 32px; text-align: center; cursor: pointer; transition: all 0.2s; background: #fafafa; }
    .upload-area:hover { background: #f0f7ff; border-color: #8BB5D9; }
    .upload-area input { display: none; }
    .upload-area p { color: #999; font-size: 14px; margin-top: 8px; }
    .upload-area .icon { font-size: 36px; }
    #preview-img { width: 100%; border-radius: 10px; margin-top: 12px; display: none; }
    .btn-upload { width: 100%; padding: 16px; background: #A8C8E8; color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.3s; box-shadow: 0 4px 15px rgba(168,200,232,0.3); margin-top: 8px; }
    .btn-upload:hover { background: #8BB5D9; transform: translateY(-2px); }
    .btn-skip { width: 100%; padding: 12px; background: transparent; color: #999; border: 1.5px solid #e8e8e8; border-radius: 14px; font-size: 14px; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s; margin-top: 10px; }
    .btn-skip:hover { color: #555; border-color: #ccc; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="bukti-wrap">
    <h1>Upload Bukti Bayar</h1>
    <p class="sub">Pesanan <strong>#{{ $pesanan->idPesanan }}</strong> berhasil dibuat!</p>

    {{-- Info Pesanan --}}
    <div class="form-card">
        <h3>📋 Detail Pesanan</h3>
        <div class="info-row">
            <span>No. Pesanan</span>
            <span>#{{ $pesanan->idPesanan }}</span>
        </div>
        <div class="info-row">
            <span>Metode Bayar</span>
            <span>{{ ucfirst($pesanan->metodePembayaran) }}</span>
        </div>
        <div class="info-row">
            <span>Tanggal</span>
            <span>{{ \Carbon\Carbon::parse($pesanan->tglPesanan)->format('d M Y') }}</span>
        </div>
        <div class="info-row">
            <span>Status</span>
            <span style="color: #f39c12;">⏳ Menunggu Pembayaran</span>
        </div>
    </div>

    {{-- Info Rekening --}}
    @if($pesanan->metodePembayaran !== 'cod')
    <div class="rekening-box">
        <p>Transfer ke rekening:</p>
        <strong>BCA — 1234 5678 90</strong>
        <p style="margin-top:6px; font-size:13px;">a/n <strong>Cloud Cafe</strong></p>
        <p style="margin-top:8px; font-size:12px; color:#888;">Nominal sesuai total pesanan kamu</p>
    </div>

    {{-- Form Upload --}}
    <form method="POST" action="{{ route('checkout.upload-bukti', $pesanan->idPesanan) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-card">
            <h3>📎 Upload Bukti Transfer</h3>
            <div class="upload-area" onclick="document.getElementById('bukti_file').click()">
                <div class="icon">🖼️</div>
                <p>Klik untuk pilih foto bukti transfer</p>
                <p style="font-size:12px;">JPG, PNG, maks 2MB</p>
                <input type="file" id="bukti_file" name="bukti_bayar" accept="image/*" onchange="previewImage(this)">
                <img id="preview-img" src="" alt="Preview">
            </div>
            @error('bukti_bayar')
                <p style="color:#e74c3c; font-size:13px; margin-top:8px;">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn-upload">✅ Kirim Bukti Pembayaran</button>
    </form>
    @else
    <div class="form-card" style="text-align:center; padding: 40px;">
        <div style="font-size:48px; margin-bottom:16px;">🚚</div>
        <h3>COD — Bayar di Tempat</h3>
        <p style="color:#777; font-size:14px; margin-top:8px;">Siapkan uang pas saat pesanan tiba ya!</p>
    </div>
    @endif

    {{-- Skip --}}
    <a href="{{ route('riwayat.index') }}">
        <button class="btn-skip">Nanti saja, lihat pesanan saya →</button>
    </a>
</div>

<script>
function previewImage(input) {
    const img = document.getElementById('preview-img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection