@extends('layouts.appuserui')

@section('content')
@php
    $totalProducts = $featuredProducts->count() ?? 0;
@endphp

<header class="hero">
    <div class="container">
        <div class="glass-card feature text-center">
            <span class="eyebrow">Modern E-Commerce Platform</span>

            <h1 class="premium-title display-4 mt-2">
                Discover products through a clean shopping experience.
            </h1>

            <p class="lead text-secondary mx-auto" style="max-width: 760px;">
                HanaShop is a modern storefront for browsing product categories, viewing product details,
                adding items to cart, and completing checkout in a simple premium flow.
            </p>

            <div class="hero-actions justify-content-center mt-4">
                <a class="btn btn-primary" href="#categories">
                    Start Shopping
                </a>

                <a class="btn btn-soft" href="{{ route('cart') }}">
                    View Cart
                </a>
            </div>

            <div class="row g-3 mt-4">
                <div class="col-md-4">
                    <div class="metric">
                        <strong>{{ $categories->count() }}</strong>
                        <span>Categories</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="metric">
                        <strong>{{ $totalProducts }}</strong>
                        <span>Featured Products</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="metric">
                        <strong>Cart</strong>
                        <span>Checkout ready</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="section" id="categories">
    <div class="container">
        <div class="section-head">
            <h2>Browse categories</h2>
            <p>Choose a category and browse products through clean, responsive storefront cards.</p>
        </div>

        <div class="grid-3">
            @forelse($categories as $category)
                <a class="glass-card feature" href="{{ route('category.show', $category->slug) }}">
                    <div class="icon">
                        <i class="bi {{ $category->icon ?? 'bi-tag' }}"></i>
                    </div>
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->description ?: 'Browse products in this category.' }}</p>
                </a>
            @empty
                <div class="glass-card feature">
                    <div class="icon">＋</div>
                    <h3>No categories yet</h3>
                    <p>Categories added from the admin dashboard will appear here.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Featured products</h2>
            <p>Latest products from active categories with images, prices, and detailed product pages.</p>
        </div>

        <div class="grid-3">
            @forelse($featuredProducts as $product)
                @include('shopping.partials.product-card', [
                    'product' => $product,
                    'category' => $product->category,
                    'fallbackClass' => 'slate'
                ])
            @empty
                <div class="glass-card feature">
                    <div class="icon">◇</div>
                    <h3>No products yet</h3>
                    <p>Products added from the admin dashboard will appear here.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="glass-card feature d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div>
                <span class="eyebrow">Shopping Cart</span>
                <h3 class="mb-1">Ready to review your selected products?</h3>
                <p class="mb-0">Open your cart to update quantities, remove products, or complete checkout.</p>
            </div>

            <a class="btn btn-primary" href="{{ route('cart') }}">View Cart</a>
        </div>
    </div>
</section>
@endsection