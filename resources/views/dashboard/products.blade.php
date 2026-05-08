@extends('layouts.appdash')

@section('content')
<div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-4">
    <div><span class="eyebrow">Products</span><h1 class="premium-title mb-0">Manage Products</h1></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproducts"><i class="bi bi-plus-lg"></i> Add Product</button>
</div>

<div class="modal fade" id="addproducts" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium-card border-0">
            <form action="{{ route('products.store') }}" method="post">@csrf
                <div class="modal-header border-0"><h5 class="modal-title premium-title">Add Product</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <label class="form-label fw-bold">Product Name</label><input type="text" class="form-control mb-3" name="productname" required>
                    <label class="form-label fw-bold">Description</label><input type="text" class="form-control" name="description" required>
                </div>
                <div class="modal-footer border-0"><button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Save</button></div>
            </form>
        </div>
    </div>
</div>

<div class="premium-card p-3 p-lg-4">
    <div class="table-responsive">
        <table class="table align-middle text-center mb-0">
            <thead><tr><th>#</th><th>Product</th><th>Description</th><th>Action</th></tr></thead>
            <tbody>
            @forelse($prod as $item)
                <tr>
                    <td>{{ $item->id }}</td><td class="fw-bold">{{ $item->name }}</td><td>{{ $item->Description }}</td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a class="btn btn-sm btn-outline-success rounded-pill" href="{{ route('products.edit', $item->id) }}"><i class="bi bi-pencil-square"></i></a>
                            <form method="POST" action="{{ route('products.destroy', $item->id) }}" onsubmit="return confirm('Delete this product?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger rounded-pill"><i class="bi bi-trash"></i></button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No products yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
