<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:#D6EAF8; min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .container { text-align:center; animation:fadeUp 0.6s ease; }
        .code { font-family:'Playfair Display',serif; font-size:120px; color:#A8C8E8; line-height:1; margin-bottom:16px; }
        .title { font-family:'Playfair Display',serif; font-size:28px; color:#1a1a2e; margin-bottom:12px; }
        .desc { color:#888; font-size:16px; margin-bottom:32px; }
        .btn { display:inline-block; padding:14px 32px; background:#A8C8E8; color:#fff; text-decoration:none; border-radius:30px; font-weight:600; font-size:15px; transition:all 0.3s; box-shadow:0 4px 15px rgba(168,200,232,0.4); }
        .btn:hover { background:#8BB5D9; transform:translateY(-2px); }
        .emoji { font-size:60px; margin-bottom:16px; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body>
    <div class="container">
        <div class="emoji">🚫</div>
        <div class="code">403</div>
        <div class="title">Akses Ditolak</div>
        <div class="desc">Kamu tidak punya izin untuk mengakses halaman ini.<br>Silakan login dengan akun yang sesuai.</div>
        <a href="/" class="btn">← Kembali ke Home</a>
    </div>
</body>
</html>