@extends('layouts.appuserui')

@section('content')
@php
    $totalProducts = ($electronics->count() ?? 0) + ($decor->count() ?? 0) + ($kitchenTools->count() ?? 0);
@endphp

<header class="hero">
    <div class="container hero-grid">
        <div>
            <span class="eyebrow">Modern E-Commerce Platform</span>
            <h1>Build a premium shopping experience with simple management tools.</h1>
            <p>
                HanaShop helps you showcase products, manage categories, handle carts, track customers,
                and review invoices through a clean storefront and admin dashboard.
            </p>

            <div class="hero-actions">
                <a class="btn btn-primary" href="{{ route('electric') }}">Explore Products</a>
                <a class="btn btn-soft" href="{{ route('cart') }}">View Cart</a>
                <a class="btn btn-soft" href="{{ route('login') }}">Admin Dashboard</a>
            </div>
        </div>

        <div class="hero-card">
            <div class="hero-card-top">
                <div class="showcase s1">
                    <h3>Storefront</h3>
                    <span>Premium customer experience</span>
                </div>

                <div class="showcase s2">
                    <h3>Dashboard</h3>
                    <span>Clean admin workspace</span>
                </div>
            </div>

            <div class="metrics">
                <div class="metric">
                    <strong>3</strong>
                    <span>Categories</span>
                </div>

                <div class="metric">
                    <strong>{{ $totalProducts }}</strong>
                    <span>Products</span>
                </div>

                <div class="metric">
                    <strong>1</strong>
                    <span>Dashboard</span>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Browse product categories</h2>
            <p>Use the current sample categories to browse products and test the shopping experience.</p>
        </div>

        <div class="grid-3">
            <a class="glass-card feature" href="{{ route('zena') }}">
                <div class="icon">✦</div>
                <h3>Decor</h3>
                <p>A sample category for showcasing lifestyle and home products.</p>
            </a>

            <a class="glass-card feature" href="{{ route('kitchenTools') }}">
                <div class="icon">◈</div>
                <h3>Kitchen Tools</h3>
                <p>A sample category for organized product browsing and catalog testing.</p>
            </a>

            <a class="glass-card feature" href="{{ route('electric') }}">
                <div class="icon">⌁</div>
                <h3>Electronics</h3>
                <p>A sample category for products with pricing, stock, images, and details.</p>
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Featured products</h2>
            <p>Product cards display category, image, price, and quick access to detailed product pages.</p>
        </div>

        <div class="grid-3">
            @foreach($electronics as $product)
                @include('shopping.partials.product-card', [
                    'product' => $product,
                    'category' => 'electronics',
                    'fallbackClass' => 'slate',
                    'price' => 699
                ])
            @endforeach

            @foreach($decor as $product)
                @include('shopping.partials.product-card', [
                    'product' => $product,
                    'category' => 'decor',
                    'fallbackClass' => 'gold',
                    'price' => 49
                ])
            @endforeach

            @foreach($kitchenTools as $product)
                @include('shopping.partials.product-card', [
                    'product' => $product,
                    'category' => 'kitchen',
                    'fallbackClass' => 'mint',
                    'price' => 79
                ])
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Admin management features</h2>
            <p>HanaShop includes practical management areas for products, customers, carts, checkout, and invoices.</p>
        </div>

        <div class="grid-3 equal-grid admin-feature-grid">
            <article class="glass-card feature admin-feature">
                <div class="icon">＋</div>
                <h3>Product Management</h3>
                <p>Add, edit, categorize, price, and upload product images from one dashboard area.</p>
            </article>

            <article class="glass-card feature admin-feature">
                <div class="icon">◎</div>
                <h3>Cart & Checkout</h3>
                <p>Customers can add products to a cart and complete checkout with customer details.</p>
            </article>

            <article class="glass-card feature admin-feature">
                <div class="icon">▣</div>
                <h3>Customer & Invoice Tracking</h3>
                <p>Review customer records, quantities, prices, totals, and revenue from the admin dashboard.</p>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="glass-card feature d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <span class="eyebrow">Store Administration</span>
                <h3 class="mb-1">Manage HanaShop from one dashboard.</h3>
                <p class="mb-0">Access products, customers, invoices, revenue metrics, and checkout records.</p>
            </div>

            <a class="btn btn-primary" href="{{ route('login') }}">Admin Login</a>
        </div>
    </div>
</section>
@endsection