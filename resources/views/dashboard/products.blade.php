@extends('layouts.appdash')

@section('content')
@php
    $categoryLabels = $categories->pluck('name', 'slug')->toArray();
@endphp

<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Products</span>
        <h1 class="premium-title mb-1">Product Management</h1>
        <p class="text-muted mb-0">
            Add, edit, delete, and manage product details from one admin workspace.
        </p>
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
    <div class="col-md-3">
        <div class="metric premium-card">
            <span class="metric-label">Total Products</span>
            <strong>{{ $prod->count() }}</strong>
            <small>Items in catalog</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="metric premium-card">
            <span class="metric-label">With Details</span>
            <strong>{{ $prod->whereNotNull('detail_id')->count() }}</strong>
            <small>Price, stock, and image</small>
        </div>
    </div>

    <div class="col-md-3">
        <a href="{{ route('categories.index') }}" class="text-decoration-none">
            <div class="metric premium-card">
                <span class="metric-label">Categories</span>
                <strong>{{ $categories->count() }}</strong>
                <small>Active storefront groups</small>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <div class="metric premium-card">
            <span class="metric-label">Workspace</span>
            <strong>Unified</strong>
            <small>Manage all product data here</small>
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

                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected(old('category') === $category->slug)>
                                {{ $category->name }}
                            </option>
                        @endforeach
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
            <p class="text-muted mb-0">
                Manage product info, category, price, stock, color, and image from this page.
            </p>
        </div>
        <a class="pill" href="{{ route('categories.index') }}">Manage Categories</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th class="text-start">Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Color</th>
                    <th class="text-start">Description</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($prod as $item)
                    @php
                        $category = $item->category ?? '';
                        $categoryLabel = $categoryLabels[$category] ?? ($category ? ucfirst(str_replace('-', ' ', $category)) : 'Uncategorized');

                        $imageUrl = null;

                        if (!empty($item->image)) {
                            $imageUrl = str_starts_with($item->image, 'http')
                                ? $item->image
                                : asset('storage/' . $item->image);
                        }

                        $currentCategoryExists = $categories->contains('slug', $category);
                    @endphp

                    <tr>
                        <td>
                            <div
                                class="product-media slate mx-auto"
                                style="width:74px;height:74px;min-width:74px;border-radius:20px;@if($imageUrl) background-image:linear-gradient(135deg,rgba(15,23,42,.45),rgba(15,23,42,.1)),url('{{ $imageUrl }}');background-size:cover;background-position:center; @endif"
                            >
                                @unless($imageUrl)
                                    <i class="bi bi-image"></i>
                                @endunless
                            </div>
                        </td>

                        <td class="fw-bold text-start">{{ $item->name }}</td>

                        <td>
                            <span class="status">{{ $categoryLabel }}</span>
                        </td>

                        <td>
                            @if(!is_null($item->price))
                                SAR {{ number_format((float) $item->price, 2) }}
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </td>

                        <td>
                            @if(!is_null($item->qty))
                                {{ $item->qty }}
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </td>

                        <td>
                            @if(!empty($item->color))
                                <span class="status">{{ $item->color }}</span>
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </td>

                        <td class="text-start text-muted">{{ $item->Description }}</td>

                        <td>
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                <button
                                    class="btn btn-sm btn-outline-success rounded-pill"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editProduct{{ $item->id }}"
                                    title="Edit product"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <button
                                    class="btn btn-sm btn-outline-primary rounded-pill"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailsProduct{{ $item->id }}"
                                    title="Manage details"
                                >
                                    <i class="bi bi-card-image"></i>
                                </button>

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

                    <div class="modal fade" id="editProduct{{ $item->id }}" tabindex="-1" aria-labelledby="editProductLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content premium-card border-0">
                                <form action="{{ route('products.update', $item->id) }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header border-0">
                                        <div>
                                            <span class="eyebrow">Edit Product</span>
                                            <h5 class="modal-title premium-title mb-0" id="editProductLabel{{ $item->id }}">
                                                {{ $item->name }}
                                            </h5>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label class="form-label fw-bold">Product Name</label>
                                        <input
                                            type="text"
                                            class="form-control mb-3"
                                            name="name"
                                            value="{{ old('name', $item->name) }}"
                                            required
                                        >

                                        <label class="form-label fw-bold">Category</label>
                                        <select class="form-select mb-3" name="category" required>
                                            @if($category && ! $currentCategoryExists)
                                                <option value="{{ $category }}" selected>
                                                    {{ $categoryLabel }} (inactive)
                                                </option>
                                            @endif

                                            @foreach($categories as $categoryOption)
                                                <option
                                                    value="{{ $categoryOption->slug }}"
                                                    @selected(old('category', $item->category) === $categoryOption->slug)
                                                >
                                                    {{ $categoryOption->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <label class="form-label fw-bold">Description</label>
                                        <textarea
                                            class="form-control"
                                            name="description"
                                            rows="4"
                                            required
                                        >{{ old('description', $item->Description) }}</textarea>
                                    </div>

                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="detailsProduct{{ $item->id }}" tabindex="-1" aria-labelledby="detailsProductLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content premium-card border-0">
                                <form action="{{ route('product-details.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="product_no" value="{{ $item->id }}">

                                    <div class="modal-header border-0">
                                        <div>
                                            <span class="eyebrow">Product Details</span>
                                            <h5 class="modal-title premium-title mb-0" id="detailsProductLabel{{ $item->id }}">
                                                {{ $item->name }}
                                            </h5>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">SAR</span>
                                                    <input
                                                        type="number"
                                                        step="0.01"
                                                        min="0"
                                                        class="form-control"
                                                        name="price"
                                                        value="{{ old('price', $item->price ?? '') }}"
                                                        placeholder="99.00"
                                                        required
                                                    >
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Quantity</label>
                                                <input
                                                    type="number"
                                                    min="0"
                                                    class="form-control"
                                                    name="qty"
                                                    value="{{ old('qty', $item->qty ?? '') }}"
                                                    placeholder="10"
                                                    required
                                                >
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Color</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="color"
                                                    value="{{ old('color', $item->color ?? 'Premium') }}"
                                                    placeholder="Premium"
                                                    required
                                                >
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-bold">Product Image</label>
                                                <input
                                                    type="file"
                                                    class="form-control"
                                                    name="img"
                                                    accept="image/png,image/jpeg,image/jpg,image/webp"
                                                >
                                                <small class="text-muted d-block mt-2">
                                                    Upload PNG, JPG, JPEG, or WEBP. Max size: 2MB.
                                                    @if($imageUrl)
                                                        Current image will remain if no new image is uploaded.
                                                    @endif
                                                </small>
                                            </div>

                                            @if($imageUrl)
                                                <div class="col-12">
                                                    <a class="pill" href="{{ $imageUrl }}" target="_blank">Open Current Image</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Details</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="8">
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