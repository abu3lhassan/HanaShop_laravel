@extends('layouts.appuserui')

@section('content')
<header class="hero">
    <div class="container hero-grid">
        <div>
            <span class="eyebrow">Premium Shopping Experience</span>
            <h1>Elegant shopping for modern homes.</h1>
            <p>HanaShop brings decor, kitchen tools, and electronics into one clean and easy-to-navigate shopping experience.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="{{ route('electric') }}">Explore Electronics</a>
                <a class="btn btn-soft" href="{{ route('zena') }}">Shop Decor</a>
            </div>
        </div>
        <div class="hero-card">
            <div class="hero-card-top">
                <div class="showcase s1"><h3>Electronics</h3><span>Smart picks</span></div>
                <div class="showcase s2"><h3>Decor</h3><span>Elegant style</span></div>
            </div>
            <div class="metrics">
                <div class="metric"><strong>3</strong><span>Categories</span></div>
                <div class="metric"><strong>{{ ($electronics->count() ?? 0) + ($decor->count() ?? 0) + ($kitchenTools->count() ?? 0) }}</strong><span>Products</span></div>
                <div class="metric"><strong>1</strong><span>Dashboard</span></div>
            </div>
        </div>
    </div>
</header>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Shop by category</h2>
            <p>Clean navigation, balanced glass cards, and quick access to product details.</p>
        </div>
        <div class="grid-3">
            <a class="glass-card feature" href="{{ route('zena') }}"><div class="icon">✦</div><h3>Decor</h3><p>Elegant home decor items for a premium atmosphere.</p></a>
            <a class="glass-card feature" href="{{ route('kitchenTools') }}"><div class="icon">◈</div><h3>Kitchen Tools</h3><p>Useful tools for organized and comfortable cooking.</p></a>
            <a class="glass-card feature" href="{{ route('electric') }}"><div class="icon">⌁</div><h3>Electronics</h3><p>Smart electronics displayed with clear product details.</p></a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Featured products</h2>
            <p>Premium cards with consistent sizes, spacing, colors, and actions.</p>
        </div>
        <div class="grid-3">
            @foreach($electronics as $product)
                @include('shopping.partials.product-card', ['product' => $product, 'category' => 'electronics', 'fallbackClass' => 'slate', 'price' => 699])
            @endforeach
            @foreach($decor as $product)
                @include('shopping.partials.product-card', ['product' => $product, 'category' => 'decor', 'fallbackClass' => 'gold', 'price' => 49])
            @endforeach
            @foreach($kitchenTools as $product)
                @include('shopping.partials.product-card', ['product' => $product, 'category' => 'kitchen', 'fallbackClass' => 'mint', 'price' => 79])
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Admin management features</h2>
            <p>HanaShop includes clear management areas for products, customers, and invoices.</p>
        </div>
        <div class="grid-3 equal-grid admin-feature-grid">
            <article class="glass-card feature admin-feature"><div class="icon">＋</div><h3>Product Management</h3><p>Add, edit, and organize products from one dashboard area.</p></article>
            <article class="glass-card feature admin-feature"><div class="icon">◎</div><h3>Customer Management</h3><p>Keep customer information organized and easy to review.</p></article>
            <article class="glass-card feature admin-feature"><div class="icon">▣</div><h3>Invoice Tracking</h3><p>Review quantities, prices, and totals in a clean invoice layout.</p></article>
        </div>
    </div>
</section>

@endsection
