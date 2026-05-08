<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HanaShop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/hanashop.css') }}">
</head>
<body class="laravel-shell">
    <nav class="navbar navbar-expand-lg premium-nav sticky-top">
        <div class="container">
            <a class="brand navbar-brand" href="{{ route('index') }}"><span class="brand-mark">H</span><span>HanaShop</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('electric') }}">Electronics</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('zena') }}">Decor</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('kitchenTools') }}">Kitchen Tools</a></li>
                    <li class="nav-item"><a class="btn btn-primary py-2 px-3" href="{{ route('login') }}">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        @if(session('success'))
            <div class="container mt-4"><div class="alert-premium">{{ session('success') }}</div></div>
        @endif
        @yield('content')
    </main>
    <footer class="footer">
        <div class="container footer-inner"><strong>HanaShop</strong><span>Ali Hussain Al-Hanabi</span></div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/hanashop.js') }}"></script>
</body>
</html>
