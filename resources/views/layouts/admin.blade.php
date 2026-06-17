<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #D6EAF8; color: #1a1a2e; display: flex; min-height: 100vh; }
        .sidebar { width: 240px; background: #1a1a2e; min-height: 100vh; padding: 32px 0; position: fixed; animation: slideRight 0.4s ease; }
        @keyframes slideRight { from { transform: translateX(-100%); } to { transform: translateX(0); } }
        .sidebar-brand { font-family: 'Playfair Display', serif; font-size: 20px; color: #fff; padding: 0 24px 32px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 24px; }
        .sidebar-brand span { color: #A8C8E8; }
        .sidebar-menu { list-style: none; }
        .sidebar-menu li a {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 24px; color: rgba(255,255,255,0.6);
            text-decoration: none; font-size: 14px; font-weight: 500;
            transition: all 0.2s; border-left: 3px solid transparent;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { color: #fff; background: rgba(168,200,232,0.15); border-left-color: #A8C8E8; }
        .sidebar-logout { margin-top: auto; padding: 24px; border-top: 1px solid rgba(255,255,255,0.1); margin-top: 40px; }
        .sidebar-logout form button { background: none; border: none; color: rgba(255,255,255,0.5); font-size: 14px; cursor: pointer; font-family: 'Inter', sans-serif; transition: color 0.2s; }
        .sidebar-logout form button:hover { color: #e74c3c; }

        .main-content { margin-left: 240px; flex: 1; padding: 40px; animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .page-header { margin-bottom: 32px; }
        .page-header h1 { font-family: 'Playfair Display', serif; font-size: 30px; }
        .page-header p { color: #888; margin-top: 4px; font-size: 14px; }

        .alert-success { background: #d4f4e2; color: #1a6b3c; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; border-left: 4px solid #2ecc71; animation: fadeUp 0.3s ease; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">☕ Coffe<span>Shop</span></div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" ...>📊 Dashboard</a></li>
            <li><a href="{{ route('admin.products.index') }}" ...>☕ Produk</a></li>
            <li><a href="{{ route('admin.orders.index') }}" ...>📋 Pesanan</a></li>
            <li><a href="{{ route('admin.histori-stok.index') }}" ...>📦 Histori Stok</a></li>
            <li><a href="{{ route('admin.laporan.index') }}" ...>💰 Laporan Keuangan</a></li>
            <li><a href="{{ route('admin.promos.index') }}" ...>🎁 Promo & Diskon</a></li>
            <li><a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">⭐ Review Produk</a></li>
            <li><a href="{{ route('admin.notifications.index') }}" class="{{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">🔔 Notifikasi</a></li>
        </ul>
        <div class="sidebar-logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button>⬅ Keluar</button>
            </form>
        </div>

        <div style="padding:0 24px;margin-top:20px;">
            <a href="{{ route('admin.notifications.index') }}" style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.6);text-decoration:none;font-size:14px;padding:10px 0;position:relative;">
                🔔 Notifikasi
                <span id="notif-badge" style="display:none;background:#e74c3c;color:#fff;border-radius:50%;width:18px;height:18px;font-size:10px;display:inline-flex;align-items:center;justify-content:center;"></span>
            </a>
        </div>

        <script>
        async function pollNotifications() {
            try {
                const res = await fetch('{{ route('admin.notifications.poll') }}');
                const data = await res.json();
                const badge = document.getElementById('notif-badge');
                if (data.count > 0) {
                    badge.style.display = 'inline-flex';
                    badge.textContent = data.count;
                } else {
                    badge.style.display = 'none';
                }
            } catch(e) {}
        }

        pollNotifications();
        setInterval(pollNotifications, 10000); // polling tiap 10 detik
        </script>
    </aside>
    <main class="main-content">
        @if(session('success'))
            <div class="alert-success">✓ {{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>