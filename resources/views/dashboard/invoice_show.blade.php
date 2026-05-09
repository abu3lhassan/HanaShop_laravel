@extends('layouts.appdash')

@section('content')
@php
    $invoiceDate = \Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d H:i');
    $categoryName = $invoice->category_name ?? ucfirst(str_replace('-', ' ', $invoice->product_category ?? 'Category'));

    $storeSettings = null;

    try {
        $storeSettings = \App\Models\StoreSetting::current();
    } catch (\Throwable $exception) {
        $storeSettings = null;
    }

    $storeName = $storeSettings->store_name ?? 'HanaShop';
    $businessName = $storeSettings->business_name ?: $storeName;
    $vatNumber = $storeSettings->vat_number ?: 'Not set';
    $crNumber = $storeSettings->cr_number ?: 'Not set';
    $storeAddress = $storeSettings->address ?: 'Not set';
    $storeCity = $storeSettings->city ?: null;
    $storeCountry = $storeSettings->country ?: null;
    $storeLogoPath = $storeSettings->logo_path ?? null;
    $invoiceNote = $storeSettings->invoice_note
        ?: 'This invoice was generated from ' . $storeName . ' checkout records.';

    /*
        VAT-ready display.
        Current invoice total is treated as subtotal because the current database schema
        does not store VAT separately yet.
    */
    $subtotal = (float) $invoice->total;
    $vatRate = (float) ($storeSettings->vat_rate ?? 15);
    $vatAmount = $subtotal * ($vatRate / 100);
    $grandTotal = $subtotal + $vatAmount;

    $fullBusinessAddress = collect([$storeAddress, $storeCity, $storeCountry])
        ->filter()
        ->implode(', ');
@endphp

<style>
    .invoice-actions {
        margin-bottom: 24px;
    }

    .invoice-screen-document {
        max-width: 900px;
        margin: 0 auto 32px auto;
        background: #ffffff;
        color: #111827;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 32px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .invoice-print-document {
        display: none;
    }

    .invoice-top {
        display: table;
        width: 100%;
        border-bottom: 2px solid #111827;
        padding-bottom: 16px;
        margin-bottom: 18px;
    }

    .invoice-top-left,
    .invoice-top-right {
        display: table-cell;
        vertical-align: top;
        width: 50%;
    }

    .invoice-top-right {
        text-align: right;
    }

    .invoice-brand-line {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .invoice-logo {
        width: 44px;
        height: 44px;
        object-fit: contain;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 4px;
        background: #ffffff;
    }

    .invoice-brand {
        font-size: 26px;
        font-weight: 800;
        margin: 0;
        color: #111827;
    }

    .invoice-small {
        font-size: 13px;
        line-height: 1.5;
        color: #374151;
        margin: 0;
    }

    .invoice-title {
        font-size: 24px;
        font-weight: 800;
        margin: 0 0 6px 0;
        color: #111827;
        text-transform: uppercase;
    }

    .invoice-number {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 6px 0;
        color: #111827;
    }

    .invoice-two-columns {
        display: table;
        width: 100%;
        margin-bottom: 18px;
        table-layout: fixed;
    }

    .invoice-column {
        display: table-cell;
        width: 50%;
        vertical-align: top;
    }

    .invoice-column:first-child {
        padding-right: 10px;
    }

    .invoice-column:last-child {
        padding-left: 10px;
    }

    .invoice-box {
        border: 1px solid #d1d5db;
        padding: 12px;
        min-height: 120px;
    }

    .invoice-box-title {
        font-size: 12px;
        font-weight: 800;
        color: #111827;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: 8px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 6px;
    }

    .invoice-row-text {
        font-size: 13px;
        line-height: 1.45;
        margin: 0 0 5px 0;
        color: #111827;
    }

    .invoice-row-text strong {
        font-weight: 700;
    }

    .invoice-items {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 18px;
        table-layout: fixed;
    }

    .invoice-items th {
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        padding: 8px 7px;
        font-size: 12px;
        color: #111827;
        text-align: center;
        font-weight: 800;
    }

    .invoice-items td {
        border: 1px solid #d1d5db;
        padding: 8px 7px;
        font-size: 13px;
        color: #111827;
        vertical-align: top;
        text-align: center;
    }

    .invoice-items .item-name {
        text-align: left;
        width: 32%;
    }

    .invoice-items .item-category {
        width: 15%;
    }

    .invoice-items .item-id {
        width: 10%;
    }

    .invoice-items .item-qty {
        width: 8%;
    }

    .invoice-items .item-price,
    .invoice-items .item-total {
        width: 17.5%;
    }

    .invoice-product-title {
        font-weight: 700;
        margin-bottom: 3px;
    }

    .invoice-product-desc {
        color: #6b7280;
        font-size: 12px;
        line-height: 1.35;
    }

    .invoice-summary-wrap {
        display: table;
        width: 100%;
        margin-top: 8px;
    }

    .invoice-summary-left,
    .invoice-summary-right {
        display: table-cell;
        vertical-align: top;
    }

    .invoice-summary-left {
        width: 55%;
        padding-right: 20px;
    }

    .invoice-summary-right {
        width: 45%;
    }

    .invoice-totals {
        width: 100%;
        border-collapse: collapse;
    }

    .invoice-totals td {
        border: 1px solid #d1d5db;
        padding: 8px 10px;
        font-size: 13px;
        color: #111827;
    }

    .invoice-totals .label {
        background: #f9fafb;
        font-weight: 700;
        text-align: left;
    }

    .invoice-totals .amount {
        text-align: right;
        font-weight: 700;
    }

    .invoice-totals .grand td {
        font-size: 15px;
        font-weight: 800;
        background: #f3f4f6;
    }

    .invoice-note {
        font-size: 12px;
        line-height: 1.45;
        color: #4b5563;
        border: 1px solid #e5e7eb;
        padding: 10px;
        margin-top: 0;
    }

    .invoice-footer {
        margin-top: 26px;
        display: table;
        width: 100%;
    }

    .invoice-footer-left,
    .invoice-footer-right {
        display: table-cell;
        width: 50%;
        vertical-align: bottom;
        font-size: 13px;
        color: #111827;
    }

    .invoice-footer-right {
        text-align: right;
    }

    .signature-line {
        display: inline-block;
        width: 180px;
        border-bottom: 1px solid #111827;
        margin-top: 22px;
    }

    @media print {
        @page {
            size: A4 portrait;
            margin: 0;
        }

        html,
        body {
            width: 210mm !important;
            min-height: 297mm !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
            color: #111827 !important;
            overflow: visible !important;
        }

        body {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .admin-sidebar,
        .admin-main > .invoice-actions,
        .invoice-actions,
        .invoice-screen-document,
        .no-print,
        .alert,
        .alert-premium,
        nav,
        header,
        footer {
            display: none !important;
        }

        .admin-main,
        .container,
        .container-fluid,
        main,
        section {
            width: 210mm !important;
            max-width: 210mm !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
            overflow: visible !important;
        }

        .invoice-print-document {
            display: block !important;
            width: 170mm !important;
            max-width: 170mm !important;
            margin: 0 auto !important;
            padding: 12mm 0 0 0 !important;
            background: #ffffff !important;
            color: #111827 !important;
            box-sizing: border-box !important;
            page-break-inside: avoid !important;
        }

        .print-header {
            width: 100%;
            display: table;
            table-layout: fixed;
            border-bottom: 2px solid #111827;
            padding-bottom: 7mm;
            margin-bottom: 6mm;
        }

        .print-header-left,
        .print-header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .print-header-right {
            text-align: right;
        }

        .print-brand-line {
            display: block;
            margin-bottom: 2mm;
        }

        .print-logo {
            width: 15mm;
            height: 15mm;
            object-fit: contain;
            border: 1px solid #d1d5db;
            padding: 1.5mm;
            margin-bottom: 2mm;
            background: #ffffff;
        }

        .print-brand {
            font-size: 19px;
            font-weight: 800;
            margin: 0 0 2mm 0;
            color: #111827;
        }

        .print-title {
            font-size: 18px;
            font-weight: 800;
            margin: 0 0 2mm 0;
            color: #111827;
            text-transform: uppercase;
        }

        .print-line {
            font-size: 10.5px;
            line-height: 1.35;
            margin: 0 0 1mm 0;
            color: #111827;
        }

        .print-columns {
            width: 100%;
            display: table;
            table-layout: fixed;
            margin-bottom: 5mm;
        }

        .print-column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .print-column:first-child {
            padding-right: 3mm;
        }

        .print-column:last-child {
            padding-left: 3mm;
        }

        .print-box {
            border: 1px solid #d1d5db;
            padding: 4mm;
            min-height: 27mm;
            box-sizing: border-box;
        }

        .print-box-title {
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 2mm;
            margin-bottom: 2mm;
        }

        .print-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 5mm;
        }

        .print-table th,
        .print-table td {
            border: 1px solid #d1d5db;
            padding: 2.2mm;
            font-size: 10px;
            line-height: 1.25;
            color: #111827;
            vertical-align: top;
            text-align: center;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .print-table th {
            background: #f3f4f6;
            font-weight: 800;
        }

        .print-table .print-item {
            width: 32%;
            text-align: left;
        }

        .print-table .print-category {
            width: 15%;
        }

        .print-table .print-id {
            width: 10%;
        }

        .print-table .print-qty {
            width: 8%;
        }

        .print-table .print-price,
        .print-table .print-total {
            width: 17.5%;
        }

        .print-product-title {
            font-weight: 700;
            margin-bottom: 1mm;
        }

        .print-product-desc {
            font-size: 9px;
            color: #4b5563;
        }

        .print-summary {
            width: 100%;
            display: table;
            table-layout: fixed;
        }

        .print-summary-note,
        .print-summary-totals {
            display: table-cell;
            vertical-align: top;
        }

        .print-summary-note {
            width: 55%;
            padding-right: 5mm;
        }

        .print-summary-totals {
            width: 45%;
        }

        .print-note {
            border: 1px solid #e5e7eb;
            padding: 3mm;
            font-size: 9px;
            line-height: 1.35;
            color: #374151;
        }

        .print-totals {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .print-totals td {
            border: 1px solid #d1d5db;
            padding: 2.5mm;
            font-size: 10.5px;
            color: #111827;
        }

        .print-totals .print-total-label {
            background: #f9fafb;
            font-weight: 700;
            text-align: left;
            width: 50%;
        }

        .print-totals .print-total-amount {
            text-align: right;
            font-weight: 700;
            width: 50%;
        }

        .print-totals .print-grand td {
            background: #f3f4f6;
            font-size: 12px;
            font-weight: 800;
        }

        .print-footer {
            width: 100%;
            display: table;
            table-layout: fixed;
            margin-top: 9mm;
        }

        .print-footer-left,
        .print-footer-right {
            display: table-cell;
            width: 50%;
            vertical-align: bottom;
            font-size: 10px;
            color: #111827;
        }

        .print-footer-right {
            text-align: right;
        }

        .print-signature-line {
            display: inline-block;
            width: 40mm;
            border-bottom: 1px solid #111827;
            margin-top: 6mm;
        }

        * {
            box-shadow: none !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        a {
            color: #111827 !important;
            text-decoration: none !important;
        }
    }
</style>

<div class="invoice-actions no-print">
    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
        <div>
            <span class="eyebrow">Invoice Details</span>
            <h1 class="premium-title mb-1">Invoice #{{ $invoice->id }}</h1>
            <p class="text-muted mb-0">
                VAT-ready invoice layout for {{ $storeName }} checkout records.
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
</div>

<div class="invoice-screen-document">
    <div class="invoice-top">
        <div class="invoice-top-left">
            <div class="invoice-brand-line">
                @if($storeLogoPath)
                    <img
                        src="{{ asset('storage/' . $storeLogoPath) }}"
                        alt="{{ $storeName }}"
                        class="invoice-logo"
                    >
                @endif

                <h2 class="invoice-brand">{{ $storeName }}</h2>
            </div>

            <p class="invoice-small">Seller: {{ $businessName }}</p>
            <p class="invoice-small">VAT Number: {{ $vatNumber }}</p>
            <p class="invoice-small">CR Number: {{ $crNumber }}</p>
            <p class="invoice-small">Address: {{ $fullBusinessAddress }}</p>
        </div>

        <div class="invoice-top-right">
            <h2 class="invoice-title">Tax Invoice</h2>
            <p class="invoice-number">#{{ $invoice->id }}</p>
            <p class="invoice-small">Date: {{ $invoiceDate }}</p>
            <p class="invoice-small">Currency: SAR</p>
        </div>
    </div>

    <div class="invoice-two-columns">
        <div class="invoice-column">
            <div class="invoice-box">
                <div class="invoice-box-title">Bill To</div>

                <p class="invoice-row-text">
                    <strong>Name:</strong>
                    {{ $invoice->customer_name ?? 'Customer #' . $invoice->costumer_id }}
                </p>

                <p class="invoice-row-text">
                    <strong>Email:</strong>
                    {{ $invoice->customer_email ?? 'No email' }}
                </p>

                <p class="invoice-row-text">
                    <strong>Phone:</strong>
                    {{ $invoice->customer_phone ?? 'No phone' }}
                </p>

                <p class="invoice-row-text">
                    <strong>Address:</strong>
                    {{ $invoice->customer_address ?? 'No address' }}
                </p>
            </div>
        </div>

        <div class="invoice-column">
            <div class="invoice-box">
                <div class="invoice-box-title">Invoice Info</div>

                <p class="invoice-row-text">
                    <strong>Invoice No:</strong>
                    #{{ $invoice->id }}
                </p>

                <p class="invoice-row-text">
                    <strong>Invoice Date:</strong>
                    {{ $invoiceDate }}
                </p>

                <p class="invoice-row-text">
                    <strong>VAT Rate:</strong>
                    {{ number_format($vatRate, 2) }}%
                </p>

                <p class="invoice-row-text">
                    <strong>Status:</strong>
                    Issued
                </p>
            </div>
        </div>
    </div>

    <table class="invoice-items">
        <thead>
            <tr>
                <th class="item-name">Item</th>
                <th class="item-category">Category</th>
                <th class="item-id">Product ID</th>
                <th class="item-qty">Qty</th>
                <th class="item-price">Unit Price</th>
                <th class="item-total">Line Total</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="item-name">
                    <div class="invoice-product-title">
                        {{ $invoice->product_name ?? 'Product #' . $invoice->products_id }}
                    </div>

                    <div class="invoice-product-desc">
                        {{ $invoice->product_description ?? 'Invoice item' }}
                    </div>
                </td>

                <td class="item-category">{{ $categoryName }}</td>

                <td class="item-id">#{{ $invoice->products_id }}</td>

                <td class="item-qty">{{ $invoice->qty }}</td>

                <td class="item-price">SAR {{ number_format((float) $invoice->price, 2) }}</td>

                <td class="item-total">
                    <strong>SAR {{ number_format($subtotal, 2) }}</strong>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="invoice-summary-wrap">
        <div class="invoice-summary-left">
            <div class="invoice-note">
                {{ $invoiceNote }}
            </div>
        </div>

        <div class="invoice-summary-right">
            <table class="invoice-totals">
                <tbody>
                    <tr>
                        <td class="label">Subtotal</td>
                        <td class="amount">SAR {{ number_format($subtotal, 2) }}</td>
                    </tr>

                    <tr>
                        <td class="label">VAT {{ number_format($vatRate, 2) }}%</td>
                        <td class="amount">SAR {{ number_format($vatAmount, 2) }}</td>
                    </tr>

                    <tr class="grand">
                        <td class="label">Grand Total</td>
                        <td class="amount">SAR {{ number_format($grandTotal, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="invoice-footer">
        <div class="invoice-footer-left">
            Prepared By: {{ $storeName }} System
        </div>

        <div class="invoice-footer-right">
            Authorized Signature
            <br>
            <span class="signature-line"></span>
        </div>
    </div>
</div>

<div class="invoice-print-document">
    <div class="print-header">
        <div class="print-header-left">
            <div class="print-brand-line">
                @if($storeLogoPath)
                    <img
                        src="{{ asset('storage/' . $storeLogoPath) }}"
                        alt="{{ $storeName }}"
                        class="print-logo"
                    >
                @endif

                <h2 class="print-brand">{{ $storeName }}</h2>
            </div>

            <p class="print-line">Seller: {{ $businessName }}</p>
            <p class="print-line">VAT Number: {{ $vatNumber }}</p>
            <p class="print-line">CR Number: {{ $crNumber }}</p>
            <p class="print-line">Address: {{ $fullBusinessAddress }}</p>
        </div>

        <div class="print-header-right">
            <h2 class="print-title">Tax Invoice</h2>
            <p class="print-line"><strong>#{{ $invoice->id }}</strong></p>
            <p class="print-line">Date: {{ $invoiceDate }}</p>
            <p class="print-line">Currency: SAR</p>
        </div>
    </div>

    <div class="print-columns">
        <div class="print-column">
            <div class="print-box">
                <div class="print-box-title">Bill To</div>
                <p class="print-line"><strong>Name:</strong> {{ $invoice->customer_name ?? 'Customer #' . $invoice->costumer_id }}</p>
                <p class="print-line"><strong>Email:</strong> {{ $invoice->customer_email ?? 'No email' }}</p>
                <p class="print-line"><strong>Phone:</strong> {{ $invoice->customer_phone ?? 'No phone' }}</p>
                <p class="print-line"><strong>Address:</strong> {{ $invoice->customer_address ?? 'No address' }}</p>
            </div>
        </div>

        <div class="print-column">
            <div class="print-box">
                <div class="print-box-title">Invoice Info</div>
                <p class="print-line"><strong>Invoice No:</strong> #{{ $invoice->id }}</p>
                <p class="print-line"><strong>Invoice Date:</strong> {{ $invoiceDate }}</p>
                <p class="print-line"><strong>VAT Rate:</strong> {{ number_format($vatRate, 2) }}%</p>
                <p class="print-line"><strong>Status:</strong> Issued</p>
            </div>
        </div>
    </div>

    <table class="print-table">
        <thead>
            <tr>
                <th class="print-item">Item</th>
                <th class="print-category">Category</th>
                <th class="print-id">Product ID</th>
                <th class="print-qty">Qty</th>
                <th class="print-price">Unit Price</th>
                <th class="print-total">Line Total</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="print-item">
                    <div class="print-product-title">
                        {{ $invoice->product_name ?? 'Product #' . $invoice->products_id }}
                    </div>

                    <div class="print-product-desc">
                        {{ $invoice->product_description ?? 'Invoice item' }}
                    </div>
                </td>

                <td class="print-category">{{ $categoryName }}</td>
                <td class="print-id">#{{ $invoice->products_id }}</td>
                <td class="print-qty">{{ $invoice->qty }}</td>
                <td class="print-price">SAR {{ number_format((float) $invoice->price, 2) }}</td>
                <td class="print-total"><strong>SAR {{ number_format($subtotal, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="print-summary">
        <div class="print-summary-note">
            <div class="print-note">
                {{ $invoiceNote }}
            </div>
        </div>

        <div class="print-summary-totals">
            <table class="print-totals">
                <tbody>
                    <tr>
                        <td class="print-total-label">Subtotal</td>
                        <td class="print-total-amount">SAR {{ number_format($subtotal, 2) }}</td>
                    </tr>

                    <tr>
                        <td class="print-total-label">VAT {{ number_format($vatRate, 2) }}%</td>
                        <td class="print-total-amount">SAR {{ number_format($vatAmount, 2) }}</td>
                    </tr>

                    <tr class="print-grand">
                        <td class="print-total-label">Grand Total</td>
                        <td class="print-total-amount">SAR {{ number_format($grandTotal, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="print-footer">
        <div class="print-footer-left">
            Prepared By: {{ $storeName }} System
        </div>

        <div class="print-footer-right">
            Authorized Signature
            <br>
            <span class="print-signature-line"></span>
        </div>
    </div>
</div>
@endsection