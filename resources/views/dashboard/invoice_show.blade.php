@extends('layouts.appdash')

@section('content')
@php
    $invoiceDate = \Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d H:i');
    $categoryName = $invoice->category_name ?? ucfirst(str_replace('-', ' ', $invoice->product_category ?? 'Category'));
@endphp

<style>
    @media print {
        .admin-sidebar,
        .no-print,
        .alert-premium,
        .alert {
            display: none !important;
        }

        .admin-main {
            width: 100% !important;
            padding: 0 !important;
        }

        body {
            background: #fff !important;
        }

        .premium-card,
        .glass-card {
            box-shadow: none !important;
            border: 1px solid #e5e7eb !important;
            background: #fff !important;
        }

        .invoice-print-area {
            margin: 0 !important;
            padding: 0 !important;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4 no-print">
    <div>
        <span class="eyebrow">Invoice Details</span>
        <h1 class="premium-title mb-1">Invoice #{{ $invoice->id }}</h1>
        <p class="text-muted mb-0">
            Review customer, product, quantity, price, and total invoice details.
        </p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="bi bi-printer me-1"></i> Print Invoice
        </button>

        <a class="btn btn-outline-dark" href="{{ route('invoices.index') }}">
            Back to Invoices
        </a>
    </div>
</div>

<div class="invoice-print-area">
    <div class="premium-card p-4 p-lg-5 mb-4">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap border-bottom pb-4 mb-4">
            <div>
                <a class="brand text-decoration-none" href="{{ route('dashboard') }}">
                    <span class="brand-mark">H</span>
                    <span>HanaShop</span>
                </a>

                <p class="text-muted mt-3 mb-0">
                    Modern e-commerce platform invoice record.
                </p>
            </div>

            <div class="text-lg-end">
                <span class="eyebrow">Invoice</span>
                <h2 class="premium-title mb-1">#{{ $invoice->id }}</h2>
                <p class="text-muted mb-0">{{ $invoiceDate }}</p>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="glass-card feature h-100">
                    <span class="eyebrow">Customer</span>
                    <h3 class="mb-3">{{ $invoice->customer_name ?? 'Customer #' . $invoice->costumer_id }}</h3>

                    <div class="side-item">
                        <span class="side-dot"></span>
                        Email: {{ $invoice->customer_email ?? 'No email' }}
                    </div>

                    <div class="side-item">
                        <span class="side-dot"></span>
                        Phone: {{ $invoice->customer_phone ?? 'No phone' }}
                    </div>

                    <div class="side-item">
                        <span class="side-dot"></span>
                        Address: {{ $invoice->customer_address ?? 'No address' }}
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="glass-card feature h-100">
                    <span class="eyebrow">Product</span>
                    <h3 class="mb-3">{{ $invoice->product_name ?? 'Product #' . $invoice->products_id }}</h3>

                    <div class="side-item">
                        <span class="side-dot"></span>
                        Category: {{ $categoryName }}
                    </div>

                    <div class="side-item">
                        <span class="side-dot"></span>
                        Product ID: #{{ $invoice->products_id }}
                    </div>

                    <div class="side-item">
                        <span class="side-dot"></span>
                        {{ $invoice->product_description ?? 'No product description' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="premium-card p-3 p-lg-4">
            <div class="table-responsive">
                <table class="table align-middle text-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-start">Item</th>
                            <th>Category</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="text-start">
                                <div class="fw-bold">{{ $invoice->product_name ?? 'Product #' . $invoice->products_id }}</div>
                                <small class="text-muted">Invoice item</small>
                            </td>

                            <td>
                                <span class="status">{{ $categoryName }}</span>
                            </td>

                            <td>{{ $invoice->qty }}</td>

                            <td>SAR {{ number_format((float) $invoice->price, 2) }}</td>

                            <td class="fw-bold">SAR {{ number_format((float) $invoice->total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <div style="min-width:280px;">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted">Subtotal</span>
                        <strong>SAR {{ number_format((float) $invoice->total, 2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span class="text-muted">Tax</span>
                        <strong>SAR 0.00</strong>
                    </div>

                    <div class="d-flex justify-content-between py-3">
                        <span class="fw-bold">Grand Total</span>
                        <strong class="fs-5">SAR {{ number_format((float) $invoice->total, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 text-muted">
            <small>
                This invoice was generated from HanaShop checkout records. Print this page or use your browser's
                “Save as PDF” option to export it.
            </small>
        </div>
    </div>
</div>
@endsection