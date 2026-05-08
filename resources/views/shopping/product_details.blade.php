@extends('layouts.appuserui')

@section('content')
@php
    $categoryRoutes = [
        'electronics' => 'electric',
        'decor' => 'zena',
        'kitchen' => 'kitchenTools',
    ];

    $categoryLabels = [
        'electronics' => 'Electronics',
        'decor' => 'Decor',
        'kitchen' => 'Kitchen Tools',
    ];

    $categoryKey = $category ?? 'electronics';
    $categoryRoute = $categoryRoutes[$categoryKey] ?? 'index';
    $categoryLabel = $categoryLabels[$categoryKey] ?? 'Product';

    $imageUrl = null;

    if (!empty($prod->image)) {
        $imageUrl = str_starts_with($prod->image, 'http')
            ? $prod->image
            : asset('storage/' . $prod->image);
    }

    $availableQty = max((int) ($prod->qty ?? 0), 0);
@endphp

<section class="section">
    <div class="container">
        <div class="hero-card">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div
                        class="product-media slate"
                        style="height:420px;@if(!empty($imageUrl)) background-image:linear-gradient(135deg,rgba(15,23,42,.55),rgba(15,23,42,.15)),url('{{ $imageUrl }}');background-size:cover;background-position:center; @endif"
                    >
                        @if(empty($imageUrl))
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="4" y="5" width="16" height="12" rx="2"/>
                                <path d="M7 15l3-3 2 2 3-4 2 5"/>
                            </svg>
                        @endif

                        <span>{{ $categoryLabel }}</span>
                    </div>
                </div>

                <div class="col-lg-6">
                    <span class="eyebrow">{{ $categoryLabel }} Product</span>
                    <h1 class="premium-title display-4">{{ $prod->name }}</h1>
                    <p class="lead text-secondary">{{ $prod->Description }}</p>

                    <div class="row g-3 my-4">
                        <div class="col-md-4 col-6">
                            <div class="metric">
                                <strong>SAR {{ number_format((float) ($prod->price ?? 0), 2) }}</strong>
                                <span>Price</span>
                            </div>
                        </div>

                        <div class="col-md-4 col-6">
                            <div class="metric">
                                <strong>{{ $availableQty }}</strong>
                                <span>Available Qty</span>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="metric">
                                <strong>{{ $prod->color ?? 'Premium' }}</strong>
                                <span>Color</span>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card feature mb-4">
                        <h3>Product Summary</h3>
                        <p class="mb-0">
                            This product is part of the {{ $categoryLabel }} collection and is displayed with clear
                            details, pricing, stock quantity, and premium HanaShop styling.
                        </p>
                    </div>

                    <div class="glass-card feature mb-4">
                        <h3>Add to Cart</h3>

                        @if($availableQty > 0)
                            <form action="{{ route('add_to_cart') }}" method="POST">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                <input type="hidden" name="category" value="{{ $categoryKey }}">

                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Quantity</label>
                                        <input
                                            type="number"
                                            name="quantity"
                                            class="form-control"
                                            value="1"
                                            min="1"
                                            max="{{ $availableQty }}"
                                            required
                                        >
                                    </div>

                                    <div class="col-md-8">
                                        <button class="btn btn-primary w-100" type="submit">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <p class="text-muted mb-0">This product is currently out of stock.</p>
                        @endif
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-soft" href="{{ route('cart') }}">
                            View Cart
                        </a>

                        <a class="btn btn-soft" href="{{ route($categoryRoute) }}">
                            Back to {{ $categoryLabel }}
                        </a>

                        <a class="btn btn-soft" href="{{ route('index') }}">
                            Back to Store
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection