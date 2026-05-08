@extends('layouts.appdash')

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Admin Dashboard</span>
        <h1 class="premium-title">HanaShop Control Center</h1>
        <p class="text-muted mb-0">
            Monitor store activity, revenue, products, categories, customers, and invoices from one premium workspace.
        </p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a class="btn btn-primary" href="{{ route('products') }}">Manage Products</a>
        <a class="btn btn-outline-dark" href="{{ route('index') }}">View Store</a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl">
        <a href="{{ route('products') }}" class="text-decoration-none">
            <div class="metric premium-card">
                <span class="metric-label">Products</span>
                <strong>{{ $productsCount ?? 0 }}</strong>
                <small>Catalog items</small>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-xl">
        <a href="{{ route('categories.index') }}" class="text-decoration-none">
            <div class="metric premium-card">
                <span class="metric-label">Categories</span>
                <strong>{{ $categoriesCount ?? 0 }}</strong>
                <small>Storefront groups</small>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-xl">
        <a href="{{ route('customers.index') }}" class="text-decoration-none">
            <div class="metric premium-card">
                <span class="metric-label">Customers</span>
                <strong>{{ $customersCount ?? 0 }}</strong>
                <small>Customer records</small>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-xl">
        <a href="{{ route('invoices.index') }}" class="text-decoration-none">
            <div class="metric premium-card">
                <span class="metric-label">Invoices</span>
                <strong>{{ $invoicesCount ?? 0 }}</strong>
                <small>Sales records</small>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-xl">
        <a href="{{ route('invoices.index') }}" class="text-decoration-none">
            <div class="metric premium-card">
                <span class="metric-label">Revenue</span>
                <strong>SAR {{ number_format((float) ($totalRevenue ?? 0), 2) }}</strong>
                <small>Total checkout value</small>
            </div>
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <a href="{{ route('products') }}" class="text-decoration-none">
            <div class="metric premium-card">
                <span class="metric-label">Product Setup</span>
                <strong>{{ $detailsCount ?? 0 }}</strong>
                <small>Items with pricing, stock, and images</small>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Sold Quantity</span>
            <strong>{{ $totalSoldQuantity ?? 0 }}</strong>
            <small>Total invoice quantity</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Latest Invoice</span>
            <strong>SAR {{ number_format((float) ($latestInvoiceTotal ?? 0), 2) }}</strong>
            <small>Most recent checkout</small>
        </div>
    </div>
</div>

<div class="dashboard mt-4">
    <div class="side-preview">
        <span class="eyebrow">Business Overview</span>
        <h3>Store Performance</h3>
        <p class="text-muted">
            HanaShop tracks products, categories, checkout activity, customers, and invoice records.
        </p>

        <div class="side-item">
            <span class="side-dot"></span>
            Revenue: SAR {{ number_format((float) ($totalRevenue ?? 0), 2) }}
        </div>

        <div class="side-item">
            <span class="side-dot"></span>
            Sold quantity: {{ $totalSoldQuantity ?? 0 }}
        </div>

        <div class="side-item">
            <span class="side-dot"></span>
            Categories: {{ $categoriesCount ?? 0 }}
        </div>

        <div class="side-item">
            <span class="side-dot"></span>
            Latest invoice: SAR {{ number_format((float) ($latestInvoiceTotal ?? 0), 2) }}
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
            <span class="status">Unified</span>
        </div>

        <div class="table-row">
            <span>Categories</span>
            <a class="pill" href="{{ route('categories.index') }}">Open</a>
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