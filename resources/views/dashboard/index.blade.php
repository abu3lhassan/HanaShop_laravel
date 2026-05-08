@extends('layouts.appdash')

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Admin Dashboard</span>
        <h1 class="premium-title">HanaShop Control Center</h1>
        <p class="text-muted mb-0">
            Manage products, product details, customers, and invoices from one premium workspace.
        </p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a class="btn btn-primary" href="{{ route('products') }}">Manage Products</a>
        <a class="btn btn-outline-dark" href="{{ route('index') }}">View Store</a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <a href="{{ route('products') }}" class="text-decoration-none">
            <div class="metric premium-card">
                <span class="metric-label">Products</span>
                <strong>{{ $productsCount ?? 0 }}</strong>
                <small>Catalog items</small>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('product-details.index') }}" class="text-decoration-none">
            <div class="metric premium-card">
                <span class="metric-label">Details</span>
                <strong>{{ $detailsCount ?? 0 }}</strong>
                <small>Pricing and stock</small>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('customers.index') }}" class="text-decoration-none">
            <div class="metric premium-card">
                <span class="metric-label">Customers</span>
                <strong>{{ $customersCount ?? 0 }}</strong>
                <small>Customer records</small>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('invoices.index') }}" class="text-decoration-none">
            <div class="metric premium-card">
                <span class="metric-label">Invoices</span>
                <strong>{{ $invoicesCount ?? 0 }}</strong>
                <small>Sales documents</small>
            </div>
        </a>
    </div>
</div>

<div class="dashboard mt-4">
    <div class="side-preview">
        <span class="eyebrow">Quick Overview</span>
        <h3>Store Management</h3>
        <p class="text-muted">
            HanaShop is organized around catalog management, customer records, and invoice tracking.
        </p>

        <div class="side-item">
            <span class="side-dot"></span>
            Products catalog
        </div>
        <div class="side-item">
            <span class="side-dot"></span>
            Product pricing and stock
        </div>
        <div class="side-item">
            <span class="side-dot"></span>
            Customer and invoice records
        </div>
    </div>

    <div class="glass-card table-card">
        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
            <div>
                <h3 class="mb-1">Management Areas</h3>
                <p class="text-muted mb-0">Open each module and manage store data.</p>
            </div>
            <span class="status">System Active</span>
        </div>

        <div class="table-row">
            <strong>Area</strong>
            <strong>Action</strong>
            <strong>Status</strong>
        </div>

        <div class="table-row">
            <span>Products</span>
            <a class="pill" href="{{ route('products') }}">Open</a>
            <span class="status">Active</span>
        </div>

        <div class="table-row">
            <span>Product Details</span>
            <a class="pill" href="{{ route('product-details.index') }}">Open</a>
            <span class="status">Active</span>
        </div>

        <div class="table-row">
            <span>Customers</span>
            <a class="pill" href="{{ route('customers.index') }}">Open</a>
            <span class="status">Active</span>
        </div>

        <div class="table-row">
            <span>Invoices</span>
            <a class="pill" href="{{ route('invoices.index') }}">Open</a>
            <span class="status">Active</span>
        </div>
    </div>
</div>
@endsection