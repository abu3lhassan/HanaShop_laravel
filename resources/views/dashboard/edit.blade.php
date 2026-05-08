@extends('layouts.appdash')

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Edit Product</span>
        <h1 class="premium-title mb-1">{{ $products->name }}</h1>
        <p class="text-muted mb-0">Update the product name and description shown in HanaShop.</p>
    </div>

    <a class="btn btn-outline-dark" href="{{ route('products') }}">Back to Products</a>
</div>

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

<div class="row g-4">
    <div class="col-lg-8">
        <div class="premium-card p-4">
            <div class="mb-4">
                <h3 class="mb-1">Product Information</h3>
                <p class="text-muted mb-0">Keep the catalog name and description clear for customers.</p>
            </div>

            <form action="{{ route('products.update', $products->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Product Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $products->name) }}"
                        class="form-control"
                        placeholder="Example: Smart Wireless Headphones"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Description</label>
                    <textarea
                        name="description"
                        class="form-control"
                        rows="5"
                        placeholder="Write a short product description."
                        required
                    >{{ old('description', $products->Description) }}</textarea>
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-primary">Save Changes</button>
                    <a class="btn btn-soft" href="{{ route('products') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="glass-card feature h-100">
            <span class="eyebrow">Product Record</span>
            <h3 class="mb-3">#{{ $products->id }}</h3>

            <div class="side-item">
                <span class="side-dot"></span>
                Editable catalog item
            </div>

            <div class="side-item">
                <span class="side-dot"></span>
                Product details are managed separately
            </div>

            <div class="side-item">
                <span class="side-dot"></span>
                Price, stock, color, and image are in Product Details
            </div>

            <a class="btn btn-primary mt-4" href="{{ route('product-details.index') }}">
                Manage Details
            </a>
        </div>
    </div>
</div>
@endsection