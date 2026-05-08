@extends('layouts.appuserui')

@section('content')
<section class="section">
    <div class="container">
        <div class="glass-card feature d-flex justify-content-between align-items-center gap-3 flex-wrap mb-4">
            <div>
                <span class="eyebrow">Kitchen Tools Collection</span>
                <h2 class="mb-2">Useful tools for modern kitchens.</h2>
                <p class="mb-0">
                    Browse HanaShop kitchen tools in balanced premium cards with clean details and easy navigation.
                </p>
            </div>

            <div class="metric">
                <strong>{{ $products->count() }}</strong>
                <span>Products</span>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap mb-4">
            <a class="btn btn-soft" href="{{ route('electric') }}">Electronics</a>
            <a class="btn btn-soft" href="{{ route('zena') }}">Decor</a>
            <a class="btn btn-primary" href="{{ route('kitchenTools') }}">Kitchen Tools</a>
        </div>

        <div class="grid-3">
            @forelse($products as $product)
                @include('shopping.partials.product-card', [
                    'product' => $product,
                    'category' => 'kitchen',
                    'fallbackClass' => 'mint'
                ])
            @empty
                <div class="glass-card feature">
                    <div class="icon">◈</div>
                    <h3>No kitchen tools yet</h3>
                    <p>Add kitchen tools from the dashboard to display them in this collection.</p>
                    <a class="btn btn-primary" href="{{ route('products') }}">Manage Products</a>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection