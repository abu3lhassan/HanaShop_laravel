@extends('layouts.appdash')

@section('content')
@php
    $totalRevenue = $invoices->sum('total');
    $totalQuantity = $invoices->sum('qty');

    $categoryLabels = [
        'electronics' => 'Electronics',
        'decor' => 'Decor',
        'kitchen' => 'Kitchen Tools',
    ];
@endphp

<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Invoices</span>
        <h1 class="premium-title mb-1">Invoice Management</h1>
        <p class="text-muted mb-0">Review sales invoices, customers, products, quantities, prices, and total revenue.</p>
    </div>

    <a class="btn btn-outline-dark" href="{{ route('dashboard') }}">Back to Dashboard</a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Total Invoices</span>
            <strong>{{ $invoices->count() }}</strong>
            <small>Sales records</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Total Quantity</span>
            <strong>{{ $totalQuantity }}</strong>
            <small>Items sold</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Total Revenue</span>
            <strong>SAR {{ number_format($totalRevenue, 2) }}</strong>
            <small>Invoice totals</small>
        </div>
    </div>
</div>

<div class="premium-card p-3 p-lg-4">
    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
        <div>
            <h3 class="mb-1">Invoice Records</h3>
            <p class="text-muted mb-0">Track checkout purchases with customer and product details.</p>
        </div>

        <span class="status">SAR</span>
    </div>

    <div class="table-responsive">
        <table class="table align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-start">Customer</th>
                    <th class="text-start">Product</th>
                    <th>Category</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse($invoices as $invoice)
                    @php
                        $category = $invoice->product_category ?? 'electronics';
                        $categoryLabel = $categoryLabels[$category] ?? ucfirst($category);
                    @endphp

                    <tr>
                        <td>{{ $invoice->id }}</td>

                        <td class="text-start">
                            <div class="fw-bold">
                                {{ $invoice->customer_name ?? 'Customer #' . $invoice->costumer_id }}
                            </div>
                            <small class="text-muted">
                                {{ $invoice->customer_email ?? 'No email' }}
                            </small>
                        </td>

                        <td class="text-start">
                            <div class="fw-bold">
                                {{ $invoice->product_name ?? 'Product #' . $invoice->products_id }}
                            </div>
                            <small class="text-muted">
                                Product ID: #{{ $invoice->products_id }}
                            </small>
                        </td>

                        <td>
                            <span class="status">{{ $categoryLabel }}</span>
                        </td>

                        <td>{{ $invoice->qty }}</td>

                        <td>SAR {{ number_format($invoice->price, 2) }}</td>

                        <td class="fw-bold">SAR {{ number_format($invoice->total, 2) }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="py-5">
                                <h5 class="mb-1">No invoices yet</h5>
                                <p class="text-muted mb-0">Invoice records will appear here once checkout is completed.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection