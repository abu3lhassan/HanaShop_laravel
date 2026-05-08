@extends('layouts.appdash')

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Admin Dashboard</span>
        <h1 class="premium-title">HanaShop Control Center</h1>
    </div>
    <a class="btn btn-primary" href="{{ route('products') }}">Manage Products</a>
</div>
<div class="row g-4">
    <div class="col-md-3"><div class="metric premium-card"><strong>{{ $productsCount ?? 0 }}</strong><span>Products</span></div></div>
    <div class="col-md-3"><div class="metric premium-card"><strong>{{ $detailsCount ?? 0 }}</strong><span>Details</span></div></div>
    <div class="col-md-3"><div class="metric premium-card"><strong>{{ $customersCount ?? 0 }}</strong><span>Customers</span></div></div>
    <div class="col-md-3"><div class="metric premium-card"><strong>{{ $invoicesCount ?? 0 }}</strong><span>Invoices</span></div></div>
</div>
<div class="dashboard mt-4">
    <div class="side-preview"><h3>Store Management</h3><div class="side-item"><span class="side-dot"></span> Products</div><div class="side-item"><span class="side-dot"></span> Customers</div><div class="side-item"><span class="side-dot"></span> Invoices</div></div>
    <div class="glass-card table-card"><div class="table-row"><strong>Area</strong><strong>Action</strong><strong>Status</strong></div><div class="table-row"><span>Products</span><a class="pill" href="{{ route('products') }}">Open</a><span class="status">Active</span></div><div class="table-row"><span>Product Details</span><a class="pill" href="{{ route('product-details.index') }}">Open</a><span class="status">Active</span></div><div class="table-row"><span>Customers</span><a class="pill" href="{{ route('customers.index') }}">Open</a><span class="status">Active</span></div></div>
</div>
@endsection
