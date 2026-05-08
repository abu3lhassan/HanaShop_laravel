@extends('layouts.appuserui')

@section('content')
@php
    $totalProducts = ($electronics->count() ?? 0) + ($decor->count() ?? 0) + ($kitchenTools->count() ?? 0);
@endphp

<header class="hero">
    <div class="container">
        <div class="glass-card feature text-center">
            <span class="eyebrow">Modern E-Commerce Platform</span>

            <h1 class="premium-title display-4 mt-2">
                Build, manage, and showcase your online store.
            </h1>

            <p class="lead text-secondary mx-auto" style="max-width: 760px;">
                HanaShop provides a clean storefront and a practical admin dashboard for managing products,
                categories, carts, customers, checkout, invoices, and revenue metrics.
            </p>

            <div class="hero-actions justify-content-center mt-4">
                <a class="btn btn-primary" href="{{ route('electric') }}">
                    Explore Products
                </a>

                <a class="btn btn-soft" href="{{ route('cart') }}">
                    View Cart
                </a>

                <a class="btn btn-soft" href="{{ route('login') }}">
                    Admin Dashboard
                </a>
            </div>

            <div class="row g-3 mt-4">
                <div class="col-md-4">
                    <div class="metric">
                        <strong>{{ $totalProducts }}</strong>
                        <span>Products</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="metric">
                        <strong>Cart</strong>
                        <span>Shopping flow</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="metric">
                        <strong>Admin</strong>
                        <span>Management tools</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Browse product categories</h2>
            <p>Choose a category and browse products through clean, premium, and responsive cards.</p>
        </div>

        <div class="grid-3">
            <a class="glass-card feature" href="{{ route('electric') }}">
                <div class="icon">⌁</div>
                <h3>Electronics</h3>
                <p>Browse products with pricing, stock, images, and detailed product pages.</p>
            </a>

            <a class="glass-card feature" href="{{ route('zena') }}">
                <div class="icon">✦</div>
                <h3>Decor</h3>
                <p>Explore a sample product category with storefront cards and checkout support.</p>
            </a>

            <a class="glass-card feature" href="{{ route('kitchenTools') }}">
                <div class="icon">◈</div>
                <h3>Kitchen Tools</h3>
                <p>Review another sample category connected to the same product management system.</p>
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Featured products</h2>
            <p>Product cards display image, price, category, and quick access to detailed product pages.</p>
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
            <p>HanaShop includes practical tools for managing the store from one dashboard.</p>
        </div>

        <div class="grid-3 equal-grid admin-feature-grid">
            <article class="glass-card feature admin-feature">
                <div class="icon">＋</div>
                <h3>Product Management</h3>
                <p>Add, edit, categorize, price, and upload product images from one admin page.</p>
            </article>

            <article class="glass-card feature admin-feature">
                <div class="icon">◎</div>
                <h3>Cart & Checkout</h3>
                <p>Customers can add products to a cart and complete checkout with customer details.</p>
            </article>

            <article class="glass-card feature admin-feature">
                <div class="icon">▣</div>
                <h3>Customers & Invoices</h3>
                <p>Track customer records, quantities, prices, totals, and revenue from the dashboard.</p>
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
                <p class="mb-0">Access products, categories, customers, invoices, revenue metrics, and checkout records.</p>
            </div>

            <a class="btn btn-primary" href="{{ route('login') }}">Admin Login</a>
        </div>
    </div>
</section>
@endsection