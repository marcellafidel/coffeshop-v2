<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoffeShop — @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #D6EAF8; color: #1a1a2e; min-height: 100vh; }

        /* NAVBAR */
        .navbar {
            background: #fff;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: slideDown 0.4s ease;
        }
        @keyframes slideDown { from { transform: translateY(-100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .navbar-brand { font-family: 'Playfair Display', serif; font-size: 22px; color: #1a1a2e; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .navbar-links { display: flex; gap: 24px; align-items: center; }
        .navbar-links a { color: #555; text-decoration: none; font-size: 14px; font-weight: 500; transition: color 0.2s; }
        .navbar-links a:hover { color: #A8C8E8; }
        .btn-nav { background: #A8C8E8; color: #fff !important; padding: 8px 20px; border-radius: 20px; font-size: 13px !important; transition: background 0.2s, transform 0.2s !important; }
        .btn-nav:hover { background: #8BB5D9 !important; transform: translateY(-1px); }
        .cart-badge { background: #A8C8E8; color: #fff; border-radius: 50%; width: 20px; height: 20px; font-size: 11px; display: inline-flex; align-items: center; justify-content: center; margin-left: 4px; }

        /* CONTENT */
        .container { max-width: 1100px; margin: 0 auto; padding: 40px 24px; }

        /* ALERT */
        .alert-success {
            background: #d4f4e2; color: #1a6b3c; padding: 14px 20px;
            border-radius: 12px; margin-bottom: 24px; font-size: 14px;
            animation: fadeIn 0.4s ease;
            border-left: 4px solid #2ecc71;
        }
        .alert-error { background: #fde8e8; color: #c0392b; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; border-left: 4px solid #e74c3c; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

        /* LOGOUT FORM */
        .logout-btn { background: none; border: none; color: #555; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Inter', sans-serif; transition: color 0.2s; }
        .logout-btn:hover { color: #e74c3c; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">☕ CoffeShop</a>
        <div class="navbar-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('menu') }}">Menu</a>
            <a href="{{ route('customer.profile') }}">👤 Profil</a>
            @auth
                <a href="{{ route('cart.index') }}">
                    🛒 Keranjang
                    @php $cartCount = count(session()->get('cart', [])); @endphp
                    @if($cartCount > 0)<span class="cart-badge">{{ $cartCount }}</span>@endif
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout-btn">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}" class="btn-nav">Daftar</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">✕ {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>