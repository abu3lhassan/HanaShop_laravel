@extends('layouts.appuserui')

@section('content')
<section class="section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
            <div>
                <span class="eyebrow">Category</span>
                <h1 class="premium-title mb-1">{{ $categoryRecord->name }}</h1>
                <p class="text-muted mb-0">
                    {{ $categoryRecord->description ?: 'Browse products in this category.' }}
                </p>
            </div>

            <a class="btn btn-outline-dark" href="{{ route('index') }}">
                Back to Store
            </a>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="metric premium-card">
                    <span class="metric-label">Category</span>
                    <strong>{{ $categoryRecord->name }}</strong>
                    <small>{{ $categoryRecord->slug }}</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="metric premium-card">
                    <span class="metric-label">Products</span>
                    <strong>{{ $products->count() }}</strong>
                    <small>Items in this category</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="metric premium-card">
                    <span class="metric-label">Status</span>
                    <strong>Active</strong>
                    <small>Available on storefront</small>
                </div>
            </div>
        </div>

        <div class="grid-3">
            @forelse($products as $product)
                @include('shopping.partials.product-card', [
                    'product' => $product,
                    'category' => $categoryRecord->slug,
                    'fallbackClass' => 'slate'
                ])
            @empty
                <div class="glass-card feature">
                    <h3>No products yet</h3>
                    <p class="mb-0">Products assigned to this category will appear here.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection