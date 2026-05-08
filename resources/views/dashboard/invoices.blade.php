@extends('layouts.appdash')

@section('content')
@php
    $totalRevenue = $invoices->sum('total');
    $totalQuantity = $invoices->sum('qty');
@endphp

<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Invoices</span>
        <h1 class="premium-title mb-1">Invoice Management</h1>
        <p class="text-muted mb-0">Review sales invoices, quantities, prices, and total revenue.</p>
    </div>

    <a class="btn btn-outline-dark" href="{{ route('dashboard') }}">Back to Dashboard</a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Total Invoices</span>
            <strong>{{ $invoices->count() }}</strong>
            <small>Sales documents</small>
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
            <p class="text-muted mb-0">Track customer purchases and invoice values in Saudi Riyal.</p>
        </div>

        <span class="status">SAR</span>
    </div>

    <div class="table-responsive">
        <table class="table align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer ID</th>
                    <th>Product ID</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->id }}</td>
                        <td>
                            <span class="status">#{{ $invoice->costumer_id }}</span>
                        </td>
                        <td>
                            <span class="status">#{{ $invoice->products_id }}</span>
                        </td>
                        <td>{{ $invoice->qty }}</td>
                        <td>SAR {{ number_format($invoice->price, 2) }}</td>
                        <td class="fw-bold">SAR {{ number_format($invoice->total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="py-5">
                                <h5 class="mb-1">No invoices yet</h5>
                                <p class="text-muted mb-0">Invoice records will appear here once sales are added to the system.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection