<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HanaShop Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/hanashop.css') }}">
</head>
<body class="laravel-shell">
<div class="container-fluid">
    <div class="row">
        <aside class="col-12 col-lg-3 col-xl-2 admin-sidebar p-4">
            <a class="brand text-white mb-4 d-flex" href="{{ route('dashboard') }}"><span class="brand-mark">H</span><span>HanaShop</span></a>
            <nav class="d-grid gap-2">
                <a class="admin-link" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a class="admin-link" href="{{ route('products') }}"><i class="bi bi-box-seam"></i> Products</a>
                <a class="admin-link" href="{{ route('product-details.index') }}"><i class="bi bi-card-checklist"></i> Product Details</a>
                <a class="admin-link" href="{{ route('customers.index') }}"><i class="bi bi-people"></i> Customers</a>
                <a class="admin-link" href="{{ route('invoices.index') }}"><i class="bi bi-receipt"></i> Invoices</a>
                <a class="admin-link" href="{{ route('index') }}"><i class="bi bi-shop"></i> Store</a>
            </nav>
            <div class="mt-4 pt-4 border-top border-light border-opacity-25">
                @auth
                <div class="small text-white-50 mb-2">Signed in as</div>
                <strong>{{ Auth::user()->name }}</strong>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">@csrf<button class="btn btn-light btn-sm rounded-pill px-3">Logout</button></form>
                @endauth
            </div>
        </aside>
        <main class="col admin-main">
            @if(session('success'))<div class="alert-premium mb-4">{{ session('success') }}</div>@endif
            @if($errors->any())
                <div class="alert alert-danger rounded-4"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
