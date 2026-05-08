@extends('layouts.appdash')

@section('content')
@php
    $categoryLabels = [
        'electronics' => 'Electronics',
        'decor' => 'Decor',
        'kitchen' => 'Kitchen Tools',
    ];
@endphp

<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Products</span>
        <h1 class="premium-title mb-1">Manage Products</h1>
        <p class="text-muted mb-0">Create and manage HanaShop catalog products by category.</p>
    </div>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproducts">
        <i class="bi bi-plus-lg"></i> Add Product
    </button>
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
            <span class="metric-label">Total Products</span>
            <strong>{{ $prod->count() }}</strong>
            <small>Items in catalog</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Categories</span>
            <strong>3</strong>
            <small>Electronics, Decor, Kitchen Tools</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Next Step</span>
            <strong>Details</strong>
            <small>Add price, stock, and image</small>
        </div>
    </div>
</div>

<div class="modal fade" id="addproducts" tabindex="-1" aria-labelledby="addproductsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium-card border-0">
            <form action="{{ route('products.store') }}" method="post">
                @csrf

                <div class="modal-header border-0">
                    <div>
                        <span class="eyebrow">New Product</span>
                        <h5 class="modal-title premium-title mb-0" id="addproductsLabel">Add Product</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label fw-bold">Product Name</label>
                    <input
                        type="text"
                        class="form-control mb-3"
                        name="productname"
                        value="{{ old('productname') }}"
                        placeholder="Example: Smart Wireless Headphones"
                        required
                    >

                    <label class="form-label fw-bold">Category</label>
                    <select class="form-select mb-3" name="category" required>
                        <option value="" disabled selected>Select category</option>
                        <option value="electronics" @selected(old('category') === 'electronics')>Electronics</option>
                        <option value="decor" @selected(old('category') === 'decor')>Decor</option>
                        <option value="kitchen" @selected(old('category') === 'kitchen')>Kitchen Tools</option>
                    </select>

                    <label class="form-label fw-bold">Description</label>
                    <textarea
                        class="form-control"
                        name="description"
                        rows="4"
                        placeholder="Write a short product description."
                        required
                    >{{ old('description') }}</textarea>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="premium-card p-3 p-lg-4">
    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
        <div>
            <h3 class="mb-1">Product Catalog</h3>
            <p class="text-muted mb-0">Products added here can be completed from Product Details.</p>
        </div>
        <a class="pill" href="{{ route('product-details.index') }}">Manage Details</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-start">Product</th>
                    <th>Category</th>
                    <th class="text-start">Description</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($prod as $item)
                    @php
                        $category = $item->category ?? 'electronics';
                        $categoryLabel = $categoryLabels[$category] ?? ucfirst($category);
                    @endphp

                    <tr>
                        <td>{{ $item->id }}</td>
                        <td class="fw-bold text-start">{{ $item->name }}</td>
                        <td>
                            <span class="status">{{ $categoryLabel }}</span>
                        </td>
                        <td class="text-start text-muted">{{ $item->Description }}</td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a
                                    class="btn btn-sm btn-outline-success rounded-pill"
                                    href="{{ route('products.edit', $item->id) }}"
                                    title="Edit product"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('products.destroy', $item->id) }}"
                                    onsubmit="return confirm('Delete this product? Product details connected to it will also be removed.')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill" title="Delete product">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="py-5">
                                <h5 class="mb-1">No products yet</h5>
                                <p class="text-muted mb-3">Start by adding your first HanaShop product.</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproducts">
                                    Add Product
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection