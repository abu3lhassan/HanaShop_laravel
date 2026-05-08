@extends('layouts.appdash')

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Product Details</span>
        <h1 class="premium-title mb-1">Manage Product Details</h1>
        <p class="text-muted mb-0">Add pricing, stock, color, and product images for the HanaShop catalog.</p>
    </div>

    <a class="btn btn-outline-dark" href="{{ route('products') }}">Back to Products</a>
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
            <span class="metric-label">Products</span>
            <strong>{{ $prod->count() }}</strong>
            <small>Available catalog products</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Product Details</span>
            <strong>{{ $producdetails->count() }}</strong>
            <small>Items with price and stock</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Currency</span>
            <strong>SAR</strong>
            <small>Saudi Riyal pricing</small>
        </div>
    </div>
</div>

<div class="premium-card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
        <div>
            <h3 class="mb-1">Add Product Details</h3>
            <p class="text-muted mb-0">Select a product, then add price, quantity, color, and image URL.</p>
        </div>
        <span class="status">Catalog Setup</span>
    </div>

    <form action="{{ route('product-details.store') }}" method="post">
        @csrf

        <div class="row g-3">
            <div class="col-lg-3">
                <label class="form-label fw-bold">Product</label>
                <select class="form-select" name="product_no" required>
                    <option value="" disabled selected>Select product</option>
                    @foreach($prod as $item)
                        <option value="{{ $item->id }}" @selected(old('product_no') == $item->id)>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-2">
                <label class="form-label fw-bold">Price</label>
                <div class="input-group">
                    <span class="input-group-text">SAR</span>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        class="form-control"
                        name="price"
                        value="{{ old('price') }}"
                        placeholder="99.00"
                        required
                    >
                </div>
            </div>

            <div class="col-lg-2">
                <label class="form-label fw-bold">Quantity</label>
                <input
                    type="number"
                    min="0"
                    class="form-control"
                    name="qty"
                    value="{{ old('qty') }}"
                    placeholder="10"
                    required
                >
            </div>

            <div class="col-lg-2">
                <label class="form-label fw-bold">Color</label>
                <input
                    type="text"
                    class="form-control"
                    name="color"
                    value="{{ old('color') }}"
                    placeholder="Premium"
                    required
                >
            </div>

            <div class="col-lg-3">
                <label class="form-label fw-bold">Image URL</label>
                <input
                    type="url"
                    class="form-control"
                    name="img"
                    value="{{ old('img') }}"
                    placeholder="https://example.com/image.jpg"
                >
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap mt-4">
            <button class="btn btn-primary">Save Details</button>
            <a class="btn btn-soft" href="{{ route('product-details.index') }}">Reset</a>
        </div>
    </form>
</div>

<div class="premium-card p-3 p-lg-4">
    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
        <div>
            <h3 class="mb-1">Product Details List</h3>
            <p class="text-muted mb-0">Review pricing, stock quantity, color, and image references.</p>
        </div>
        <a class="pill" href="{{ route('index') }}">View Store</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-start">Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Color</th>
                    <th class="text-start">Image</th>
                </tr>
            </thead>

            <tbody>
                @forelse($producdetails as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td class="fw-bold text-start">{{ $item->name }}</td>
                        <td>SAR {{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>
                            <span class="status">{{ $item->color }}</span>
                        </td>
                        <td class="text-start">
                            @if(!empty($item->image))
                                <a href="{{ $item->image }}" target="_blank" class="pill">Open Image</a>
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="py-5">
                                <h5 class="mb-1">No product details yet</h5>
                                <p class="text-muted mb-0">Add details to show complete product cards in the store.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection