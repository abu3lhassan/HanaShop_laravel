@extends('layouts.appdash')

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Categories</span>
        <h1 class="premium-title mb-1">Category Management</h1>
        <p class="text-muted mb-0">
            Add, rename, and manage storefront product categories from the admin dashboard.
        </p>
    </div>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">
        <i class="bi bi-plus-lg"></i> Add Category
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
            <span class="metric-label">Total Categories</span>
            <strong>{{ $categories->count() }}</strong>
            <small>All category records</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Active Categories</span>
            <strong>{{ $categories->where('is_active', true)->count() }}</strong>
            <small>Visible for product selection</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Inactive Categories</span>
            <strong>{{ $categories->where('is_active', false)->count() }}</strong>
            <small>Hidden from new product setup</small>
        </div>
    </div>
</div>

<div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium-card border-0">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="modal-header border-0">
                    <div>
                        <span class="eyebrow">New Category</span>
                        <h5 class="modal-title premium-title mb-0" id="addCategoryLabel">Add Category</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label fw-bold">Category Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control mb-3"
                        value="{{ old('name') }}"
                        placeholder="Example: Perfumes"
                        required
                    >

                    <label class="form-label fw-bold">Description</label>
                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                        placeholder="Short category description."
                    >{{ old('description') }}</textarea>

                    <small class="text-muted d-block mt-2">
                        The URL slug will be created automatically from the category name.
                    </small>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="premium-card p-3 p-lg-4">
    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
        <div>
            <h3 class="mb-1">Category List</h3>
            <p class="text-muted mb-0">
                Manage category names, descriptions, and visibility. Existing products remain connected when a category is renamed.
            </p>
        </div>

        <a class="pill" href="{{ route('products') }}">Manage Products</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-start">Category</th>
                    <th>Slug</th>
                    <th class="text-start">Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>

                        <td class="fw-bold text-start">{{ $category->name }}</td>

                        <td>
                            <span class="status">{{ $category->slug }}</span>
                        </td>

                        <td class="text-start text-muted">
                            {{ $category->description ?: 'No description' }}
                        </td>

                        <td>
                            @if($category->is_active)
                                <span class="status">Active</span>
                            @else
                                <span class="status">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                <button
                                    class="btn btn-sm btn-outline-success rounded-pill"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editCategory{{ $category->id }}"
                                    title="Edit category"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form action="{{ route('categories.toggle', $category->id) }}" method="POST">
                                    @csrf
                                    <button
                                        class="btn btn-sm {{ $category->is_active ? 'btn-outline-warning' : 'btn-outline-primary' }} rounded-pill"
                                        type="submit"
                                        title="{{ $category->is_active ? 'Disable category' : 'Enable category' }}"
                                    >
                                        @if($category->is_active)
                                            Disable
                                        @else
                                            Enable
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryLabel{{ $category->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content premium-card border-0">
                                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header border-0">
                                        <div>
                                            <span class="eyebrow">Edit Category</span>
                                            <h5 class="modal-title premium-title mb-0" id="editCategoryLabel{{ $category->id }}">
                                                {{ $category->name }}
                                            </h5>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label class="form-label fw-bold">Category Name</label>
                                        <input
                                            type="text"
                                            name="name"
                                            class="form-control mb-3"
                                            value="{{ old('name', $category->name) }}"
                                            required
                                        >

                                        <label class="form-label fw-bold">Description</label>
                                        <textarea
                                            name="description"
                                            class="form-control"
                                            rows="4"
                                        >{{ old('description', $category->description) }}</textarea>

                                        <small class="text-muted d-block mt-2">
                                            Renaming a category will update its slug and keep existing products connected.
                                        </small>
                                    </div>

                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="py-5">
                                <h5 class="mb-1">No categories yet</h5>
                                <p class="text-muted mb-3">Start by adding your first storefront category.</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">
                                    Add Category
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