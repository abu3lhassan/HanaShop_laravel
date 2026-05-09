<!doctype html>
@php
    $dashboardSettings = null;

    try {
        $dashboardSettings = \App\Models\StoreSetting::current();
    } catch (\Throwable $exception) {
        $dashboardSettings = null;
    }

    $dashboardStoreName = $dashboardSettings->store_name ?? 'HanaShop';
    $dashboardLogoPath = $dashboardSettings->logo_path ?? null;
    $dashboardFaviconPath = $dashboardSettings->favicon_path ?? null;
    $dashboardThemeMode = in_array(($dashboardSettings->theme_mode ?? 'light'), ['light', 'dark'], true)
        ? $dashboardSettings->theme_mode
        : 'light';
@endphp
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $dashboardStoreName }} Dashboard</title>

    @if($dashboardFaviconPath)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $dashboardFaviconPath) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/hanashop.css') }}">
</head>

<body class="laravel-shell theme-{{ $dashboardThemeMode }}">
<div class="container-fluid">
    <div class="row">
        <aside class="col-12 col-lg-3 col-xl-2 admin-sidebar p-4">
            <a class="brand text-white mb-4 d-flex" href="{{ route('dashboard') }}">
                @if($dashboardLogoPath)
                    <span class="brand-mark overflow-hidden bg-white">
                        <img
                            src="{{ asset('storage/' . $dashboardLogoPath) }}"
                            alt="{{ $dashboardStoreName }}"
                            style="width: 100%; height: 100%; object-fit: contain; padding: 4px;"
                        >
                    </span>
                @else
                    <span class="brand-mark">{{ strtoupper(substr($dashboardStoreName, 0, 1)) }}</span>
                @endif

                <span>{{ $dashboardStoreName }}</span>
            </a>

            <nav class="d-grid gap-2">
                <a class="admin-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <a class="admin-link {{ request()->routeIs('products') || request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products') }}">
                    <i class="bi bi-box-seam"></i> Products
                </a>

                <a class="admin-link {{ request()->routeIs('categories.index') || request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                    <i class="bi bi-tags"></i> Categories
                </a>

                <a class="admin-link {{ request()->routeIs('customers.index') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                    <i class="bi bi-people"></i> Customers
                </a>

                <a class="admin-link {{ request()->routeIs('invoices.index') || request()->routeIs('invoices.show') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                    <i class="bi bi-receipt"></i> Invoices
                </a>

                <a class="admin-link {{ request()->routeIs('settings.index') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                    <i class="bi bi-gear"></i> Settings
                </a>

                <a class="admin-link {{ request()->routeIs('admin-users.index') ? 'active' : '' }}" href="{{ route('admin-users.index') }}">
                    <i class="bi bi-person-gear"></i> Admin Users
                </a>

                <a class="admin-link" href="{{ route('index') }}">
                    <i class="bi bi-shop"></i> Store
                </a>
            </nav>

            <div class="mt-4 pt-4 border-top border-light border-opacity-25">
                @auth
                    <div class="small text-white-50 mb-2">Signed in as</div>
                    <strong>{{ Auth::user()->name }}</strong>

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button class="btn btn-light btn-sm rounded-pill px-3">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </aside>

        <main class="col admin-main">
            @if(session('success'))
                <div class="alert-premium mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger rounded-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>