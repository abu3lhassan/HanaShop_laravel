@extends('layouts.appuserui')

@section('content')
@php
    $cartCount = collect($cart)->sum('quantity');
@endphp

<section class="section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
            <div>
                <span class="eyebrow">Shopping Cart</span>
                <h1 class="premium-title mb-1">Your Cart</h1>
                <p class="text-muted mb-0">
                    Review selected products, update quantities, and complete checkout.
                </p>
            </div>

            <a class="btn btn-outline-dark" href="{{ route('index') }}">Continue Shopping</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success rounded-4 border-0 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger rounded-4 border-0 shadow-sm">
                <strong>Please fix the following:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="metric premium-card">
                    <span class="metric-label">Cart Items</span>
                    <strong>{{ $cartCount }}</strong>
                    <small>Total selected quantity</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="metric premium-card">
                    <span class="metric-label">Subtotal</span>
                    <strong>SAR {{ number_format((float) $subtotal, 2) }}</strong>
                    <small>Before checkout</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="metric premium-card">
                    <span class="metric-label">Status</span>
                    <strong>{{ $cartCount > 0 ? 'Ready' : 'Empty' }}</strong>
                    <small>{{ $cartCount > 0 ? 'Ready for checkout' : 'Add products first' }}</small>
                </div>
            </div>
        </div>

        @if(count($cart) > 0)
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="premium-card p-3 p-lg-4">
                        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-4">
                            <div>
                                <h3 class="mb-1">Cart Products</h3>
                                <p class="text-muted mb-0">Update quantities or remove products from your cart.</p>
                            </div>

                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear all cart items?')">
                                @csrf
                                <button class="btn btn-soft" type="submit">Clear Cart</button>
                            </form>
                        </div>

                        <div class="d-grid gap-3">
                            @foreach($cart as $cartKey => $item)
                                @php
                                    $imageUrl = null;

                                    if (!empty($item['image'])) {
                                        $imageUrl = str_starts_with($item['image'], 'http')
                                            ? $item['image']
                                            : asset('storage/' . $item['image']);
                                    }

                                    $itemTotal = ((float) $item['price']) * ((int) $item['quantity']);
                                    $availableStock = $item['stock'] ?? null;
                                    $categoryLabel = $item['category_name'] ?? ucfirst(str_replace('-', ' ', $item['category']));
                                    $formId = 'update-cart-' . md5($cartKey);
                                @endphp

                                <div class="glass-card feature p-3 p-lg-4">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-lg-5">
                                            <div class="d-flex align-items-center gap-3">
                                                <div
                                                    class="product-media slate"
                                                    style="width:78px;height:78px;min-width:78px;border-radius:22px;@if($imageUrl) background-image:linear-gradient(135deg,rgba(15,23,42,.45),rgba(15,23,42,.1)),url('{{ $imageUrl }}');background-size:cover;background-position:center; @endif"
                                                >
                                                    @unless($imageUrl)
                                                        <i class="bi bi-bag"></i>
                                                    @endunless
                                                </div>

                                                <div>
                                                    <div class="fw-bold">{{ $item['name'] }}</div>
                                                    <small class="text-muted d-block">{{ $item['color'] ?? 'Premium' }}</small>
                                                    <span class="status mt-2 d-inline-block">{{ $categoryLabel }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-4 col-6">
                                            <span class="text-muted d-block small">Price</span>
                                            <strong>SAR {{ number_format((float) $item['price'], 2) }}</strong>
                                        </div>

                                        <div class="col-lg-3 col-md-4 col-6">
                                            <label class="text-muted small mb-1 d-block">Quantity</label>

                                            <input
                                                form="{{ $formId }}"
                                                type="number"
                                                name="quantity"
                                                value="{{ $item['quantity'] }}"
                                                min="1"
                                                @if(!is_null($availableStock)) max="{{ $availableStock }}" @endif
                                                class="form-control text-center"
                                                style="width:96px;max-width:100%;"
                                                required
                                            >

                                            @if(!is_null($availableStock))
                                                <small class="text-muted d-block mt-2">
                                                    Available: {{ $availableStock }}
                                                </small>
                                            @endif
                                        </div>

                                        <div class="col-lg-2 col-md-4 col-12">
                                            <span class="text-muted d-block small">Total</span>
                                            <strong>SAR {{ number_format($itemTotal, 2) }}</strong>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-md-end justify-content-start gap-2 flex-wrap mt-4 pt-3 border-top">
                                        <form id="{{ $formId }}" action="{{ route('cart.update') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                                        </form>

                                        <button
                                            form="{{ $formId }}"
                                            class="btn btn-sm btn-outline-success rounded-pill px-4"
                                            type="submit"
                                        >
                                            Update
                                        </button>

                                        <form action="{{ route('cart.remove') }}" method="POST" class="m-0" onsubmit="return confirm('Remove this product from cart?')">
                                            @csrf
                                            <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                                            <button class="btn btn-sm btn-outline-danger rounded-pill px-4" type="submit">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="glass-card feature">
                        <span class="eyebrow">Checkout</span>
                        <h3 class="mb-3">Customer Information</h3>

                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Customer Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    value="{{ old('name') }}"
                                    maxlength="30"
                                    placeholder="Full name"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    value="{{ old('email') }}"
                                    maxlength="30"
                                    placeholder="customer@email.com"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Phone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    value="{{ old('phone') }}"
                                    maxlength="30"
                                    placeholder="05xxxxxxxx"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <input
                                    type="text"
                                    name="address"
                                    class="form-control"
                                    value="{{ old('address') }}"
                                    maxlength="30"
                                    placeholder="City / district"
                                    required
                                >
                            </div>

                            <div class="mt-4 pt-3 border-top">
                                <div class="side-item">
                                    <span class="side-dot"></span>
                                    Items: {{ $cartCount }}
                                </div>

                                <div class="side-item">
                                    <span class="side-dot"></span>
                                    Currency: SAR
                                </div>

                                <div class="d-flex justify-content-between align-items-center my-3">
                                    <strong>Total</strong>
                                    <strong>SAR {{ number_format((float) $subtotal, 2) }}</strong>
                                </div>

                                <button class="btn btn-primary w-100" type="submit">
                                    Complete Checkout
                                </button>

                                <p class="text-muted mt-3 mb-0">
                                    Completing checkout will create customer and invoice records, then reduce product stock.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="glass-card feature text-center">
                <div class="icon mx-auto">
                    <i class="bi bi-cart3"></i>
                </div>
                <h3>Your cart is empty</h3>
                <p>Add products from any active category to start building your cart.</p>

                <div class="d-flex gap-2 justify-content-center flex-wrap mt-3">
                    <a class="btn btn-primary" href="{{ route('index') }}#categories">Browse Categories</a>
                    <a class="btn btn-soft" href="{{ route('index') }}">Back to Store</a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection