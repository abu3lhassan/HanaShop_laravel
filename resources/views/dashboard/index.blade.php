@extends('layouts.appdash')

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Admin Dashboard</span>
        <h1 class="premium-title">HanaShop Control Center</h1>
        <p class="text-muted mb-0">
            Monitor revenue, stock, customers, invoices, and product performance from one workspace.
        </p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a class="btn btn-primary" href="{{ route('products') }}">Manage Products</a>
        <a class="btn btn-outline-dark" href="{{ route('settings.index') }}">Store Settings</a>
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
    <div class="col-md-3">
        <div class="metric premium-card">
            <span class="metric-label">Revenue Today</span>
            <strong>SAR {{ number_format((float) ($revenueToday ?? 0), 2) }}</strong>
            <small>Current day sales</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="metric premium-card">
            <span class="metric-label">Revenue This Month</span>
            <strong>SAR {{ number_format((float) ($revenueThisMonth ?? 0), 2) }}</strong>
            <small>Monthly sales value</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="metric premium-card">
            <span class="metric-label">Sold Quantity</span>
            <strong>{{ $totalSoldQuantity ?? 0 }}</strong>
            <small>Total invoice quantity</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="metric premium-card">
            <span class="metric-label">Latest Invoice</span>
            <strong>SAR {{ number_format((float) ($latestInvoiceTotal ?? 0), 2) }}</strong>
            <small>Most recent checkout</small>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-6">
        <div class="glass-card table-card h-100">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                <div>
                    <h3 class="mb-1">Low Stock Products</h3>
                    <p class="text-muted mb-0">Products with latest stock quantity of 5 or less.</p>
                </div>

                <a class="pill" href="{{ route('products') }}">Manage</a>
            </div>

            <div class="table-row">
                <strong>Product</strong>
                <strong>Stock</strong>
                <strong>Price</strong>
            </div>

            @forelse($lowStockProducts as $product)
                <div class="table-row">
                    <span>
                        <strong>{{ $product->name }}</strong>
                        <small class="d-block text-muted">
                            {{ $product->category_name ?? ucfirst(str_replace('-', ' ', $product->category ?? 'Category')) }}
                        </small>
                    </span>

                    <span class="{{ (int) $product->qty === 0 ? 'text-danger fw-bold' : 'fw-bold' }}">
                        {{ $product->qty }}
                    </span>

                    <span>SAR {{ number_format((float) $product->price, 2) }}</span>
                </div>
            @empty
                <div class="table-row">
                    <span class="text-muted">No low stock products.</span>
                    <span>-</span>
                    <span>-</span>
                </div>
            @endforelse
        </div>
    </div>

    <div class="col-xl-6">
        <div class="glass-card table-card h-100">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                <div>
                    <h3 class="mb-1">Latest Invoices</h3>
                    <p class="text-muted mb-0">Most recent checkout records.</p>
                </div>

                <a class="pill" href="{{ route('invoices.index') }}">View All</a>
            </div>

            <div class="table-row">
                <strong>Invoice</strong>
                <strong>Customer</strong>
                <strong>Total</strong>
            </div>

            @forelse($latestInvoices as $invoice)
                <div class="table-row">
                    <a class="text-decoration-none fw-bold" href="{{ route('invoices.show', $invoice->id) }}">
                        #{{ $invoice->id }}
                    </a>

                    <span>
                        {{ $invoice->customer_name ?? 'Customer' }}
                        <small class="d-block text-muted">{{ $invoice->product_name ?? 'Product' }}</small>
                    </span>

                    <span>SAR {{ number_format((float) $invoice->total, 2) }}</span>
                </div>
            @empty
                <div class="table-row">
                    <span class="text-muted">No invoices yet.</span>
                    <span>-</span>
                    <span>-</span>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-6">
        <div class="glass-card table-card h-100">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                <div>
                    <h3 class="mb-1">Top Selling Products</h3>
                    <p class="text-muted mb-0">Products ranked by sold quantity.</p>
                </div>

                <span class="status">Sales Insight</span>
            </div>

            <div class="table-row">
                <strong>Product</strong>
                <strong>Sold</strong>
                <strong>Revenue</strong>
            </div>

            @forelse($topSellingProducts as $product)
                <div class="table-row">
                    <span>{{ $product->name ?? 'Deleted product' }}</span>
                    <strong>{{ (int) $product->sold_qty }}</strong>
                    <span>SAR {{ number_format((float) $product->revenue, 2) }}</span>
                </div>
            @empty
                <div class="table-row">
                    <span class="text-muted">No product sales yet.</span>
                    <span>-</span>
                    <span>-</span>
                </div>
            @endforelse
        </div>
    </div>

    <div class="col-xl-6">
        <div class="glass-card table-card h-100">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                <div>
                    <h3 class="mb-1">Latest Customers</h3>
                    <p class="text-muted mb-0">Recently added customer records.</p>
                </div>

                <a class="pill" href="{{ route('customers.index') }}">View All</a>
            </div>

            <div class="table-row">
                <strong>Customer</strong>
                <strong>Email</strong>
                <strong>Phone</strong>
            </div>

            @forelse($latestCustomers as $customer)
                <div class="table-row">
                    <span>{{ $customer->name }}</span>
                    <span>{{ $customer->email ?? 'No email' }}</span>
                    <span>{{ $customer->phone ?? 'No phone' }}</span>
                </div>
            @empty
                <div class="table-row">
                    <span class="text-muted">No customers yet.</span>
                    <span>-</span>
                    <span>-</span>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="dashboard mt-4">
    <div class="side-preview">
        <span class="eyebrow">Business Overview</span>
        <h3>Store Performance</h3>
        <p class="text-muted">
            HanaShop tracks products, categories, checkout activity, customers, stock health, and invoice records.
        </p>

        <div class="side-item">
            <span class="side-dot"></span>
            Total revenue: SAR {{ number_format((float) ($totalRevenue ?? 0), 2) }}
        </div>

        <div class="side-item">
            <span class="side-dot"></span>
            Revenue today: SAR {{ number_format((float) ($revenueToday ?? 0), 2) }}
        </div>

        <div class="side-item">
            <span class="side-dot"></span>
            Revenue this month: SAR {{ number_format((float) ($revenueThisMonth ?? 0), 2) }}
        </div>

        <div class="side-item">
            <span class="side-dot"></span>
            Sold quantity: {{ $totalSoldQuantity ?? 0 }}
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

        <div class="table-row">
            <span>Settings</span>
            <a class="pill" href="{{ route('settings.index') }}">Open</a>
            <span class="status">Configurable</span>
        </div>
    </div>
</div>
@endsection