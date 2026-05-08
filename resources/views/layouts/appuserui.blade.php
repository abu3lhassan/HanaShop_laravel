<!doctype html>
<html lang="en">
@php
    $cartCount = collect(session('cart', []))->sum('quantity');

    $navCategories = \App\Models\Category::where('is_active', true)
        ->orderBy('name')
        ->get();
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="HanaShop is a modern e-commerce platform with a premium shopping and admin experience.">

    <title>HanaShop | Modern E-Commerce Platform</title>

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
            <a class="brand navbar-brand" href="{{ route('index') }}" aria-label="HanaShop home">
                <span class="brand-mark">H</span>
                <span>HanaShop</span>
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarContent"
                aria-controls="navbarContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto gap-2 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link fw-bold {{ request()->routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">
                            Home
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link fw-bold dropdown-toggle {{ request()->routeIs('category.show') || request()->routeIs('electric') || request()->routeIs('zena') || request()->routeIs('kitchenTools') ? 'active' : '' }}"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            Categories
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end rounded-4 border-0 shadow">
                            @forelse($navCategories as $category)
                                <li>
                                    <a class="dropdown-item fw-semibold" href="{{ route('category.show', $category->slug) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <span class="dropdown-item text-muted">
                                        No categories yet
                                    </span>
                                </li>
                            @endforelse
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-soft py-2 px-3 position-relative {{ request()->routeIs('cart') ? 'active' : '' }}" href="{{ route('cart') }}">
                            <i class="bi bi-bag me-1"></i> Cart
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-primary py-2 px-3" href="{{ route('login') }}">
                            <i class="bi bi-grid-1x2-fill me-1"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="container mt-4">
                <div class="alert-premium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer-inner">
            <div>
                <strong>HanaShop</strong>
                <span>A modern e-commerce platform with a premium shopping and admin experience.</span>
            </div>

            <div class="d-flex gap-3 flex-wrap align-items-center">
                <span>Ali Hussain Al-Hanabi</span>
                <a href="https://www.linkedin.com/in/ali-al-hanabi-09a138151/" target="_blank" rel="noopener" aria-label="LinkedIn">
                    <i class="bi bi-linkedin"></i>
                </a>
                <a href="https://x.com/abu3lzahra" target="_blank" rel="noopener" aria-label="X">
                    <i class="bi bi-twitter-x"></i>
                </a>
                <a href="https://www.instagram.com/abu3lzahra" target="_blank" rel="noopener" aria-label="Instagram">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="https://www.alhanabi.com" target="_blank" rel="noopener" aria-label="Website">
                    <i class="bi bi-globe2"></i>
                </a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/hanashop.js') }}"></script>
</body>
</html>