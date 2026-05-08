@extends('layouts.appdash')

@section('content')
<div class="mb-4"><span class="eyebrow">Product Details</span><h1 class="premium-title">Manage Product Details</h1></div>
<div class="premium-card p-4 mb-4">
    <form action="{{ route('product-details.store') }}" method="post">@csrf
        <div class="row g-3">
            <div class="col-lg-3"><label class="form-label fw-bold">Product</label><select class="form-select" name="product_no" required>@foreach($prod as $item)<option value="{{ $item->id }}">{{ $item->name }}</option>@endforeach</select></div>
            <div class="col-lg-2"><label class="form-label fw-bold">Price</label><input type="number" step="0.01" class="form-control" name="price" required></div>
            <div class="col-lg-2"><label class="form-label fw-bold">Quantity</label><input type="number" class="form-control" name="qty" required></div>
            <div class="col-lg-2"><label class="form-label fw-bold">Color</label><input type="text" class="form-control" name="color" required></div>
            <div class="col-lg-3"><label class="form-label fw-bold">Image URL</label><input type="text" class="form-control" name="img"></div>
        </div>
        <button class="btn btn-primary mt-4">Save Details</button>
    </form>
</div>
<div class="premium-card p-3 p-lg-4">
    <div class="table-responsive"><table class="table align-middle text-center mb-0"><thead><tr><th>#</th><th>Product</th><th>Price</th><th>Qty</th><th>Color</th><th>Image</th></tr></thead><tbody>@forelse($producdetails as $item)<tr><td>{{ $item->id }}</td><td class="fw-bold">{{ $item->name }}</td><td>${{ number_format($item->price, 2) }}</td><td>{{ $item->qty }}</td><td>{{ $item->color }}</td><td class="text-truncate" style="max-width:180px">{{ $item->image }}</td></tr>@empty<tr><td colspan="6">No product details yet.</td></tr>@endforelse</tbody></table></div>
</div>
@endsection
