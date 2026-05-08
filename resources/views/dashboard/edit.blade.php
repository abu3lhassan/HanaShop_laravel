@extends('layouts.appdash')

@section('content')
<div class="mb-4"><span class="eyebrow">Edit Product</span><h1 class="premium-title">{{ $products->name }}</h1></div>
<div class="premium-card p-4">
    <form action="{{ route('products.update', $products->id) }}" method="post">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label fw-bold">Product Name</label><input type="text" name="name" value="{{ old('name', $products->name) }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label fw-bold">Description</label><input type="text" name="description" value="{{ old('description', $products->Description) }}" class="form-control" required></div>
        </div>
        <div class="mt-4 d-flex gap-2"><button class="btn btn-primary">Save</button><a class="btn btn-soft" href="{{ route('products') }}">Cancel</a></div>
    </form>
</div>
@endsection
