@extends('layouts.appdash')

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Store Configuration</span>
        <h1 class="premium-title mb-1">Store Settings</h1>
        <p class="text-muted mb-0">
            Manage your store identity, business information, VAT details, and invoice defaults.
        </p>
    </div>

    <a class="btn btn-outline-dark" href="{{ route('dashboard') }}">
        Back to Dashboard
    </a>
</div>

<form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="premium-card p-4 mb-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="icon-pill">
                        <i class="bi bi-shop"></i>
                    </div>

                    <div>
                        <h3 class="mb-1">Store Identity</h3>
                        <p class="text-muted mb-0">Basic public identity for the dashboard and future storefront display.</p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Store Name</label>
                        <input
                            type="text"
                            name="store_name"
                            class="form-control"
                            value="{{ old('store_name', $settings->store_name) }}"
                            required
                            maxlength="80"
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Business Name</label>
                        <input
                            type="text"
                            name="business_name"
                            class="form-control"
                            value="{{ old('business_name', $settings->business_name) }}"
                            maxlength="120"
                            placeholder="Legal business name"
                        >
                    </div>

                    <div class="col-12">
                        <label class="form-label">Store Description</label>
                        <textarea
                            name="store_description"
                            class="form-control"
                            rows="3"
                            maxlength="180"
                            placeholder="Short description for the store"
                        >{{ old('store_description', $settings->store_description) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Logo</label>
                        <input type="file" name="logo" class="form-control" accept=".jpg,.jpeg,.png,.webp,.svg">

                        @if($settings->logo_path)
                            <div class="mt-3 d-flex align-items-center gap-3">
                                <img
                                    src="{{ asset('storage/' . $settings->logo_path) }}"
                                    alt="Store logo"
                                    style="width: 54px; height: 54px; object-fit: cover; border-radius: 14px; border: 1px solid #e5e7eb;"
                                >
                                <small class="text-muted">Current logo</small>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Favicon / Tab Icon</label>
                        <input type="file" name="favicon" class="form-control" accept=".jpg,.jpeg,.png,.webp,.ico">

                        @if($settings->favicon_path)
                            <div class="mt-3 d-flex align-items-center gap-3">
                                <img
                                    src="{{ asset('storage/' . $settings->favicon_path) }}"
                                    alt="Store favicon"
                                    style="width: 40px; height: 40px; object-fit: cover; border-radius: 10px; border: 1px solid #e5e7eb;"
                                >
                                <small class="text-muted">Current favicon</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="premium-card p-4 mb-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="icon-pill">
                        <i class="bi bi-building"></i>
                    </div>

                    <div>
                        <h3 class="mb-1">Business Information</h3>
                        <p class="text-muted mb-0">Information used for invoices and official store documents.</p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">VAT Number</label>
                        <input
                            type="text"
                            name="vat_number"
                            class="form-control"
                            value="{{ old('vat_number', $settings->vat_number) }}"
                            maxlength="60"
                            placeholder="VAT registration number"
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Commercial Registration Number</label>
                        <input
                            type="text"
                            name="cr_number"
                            class="form-control"
                            value="{{ old('cr_number', $settings->cr_number) }}"
                            maxlength="60"
                            placeholder="CR number"
                        >
                    </div>

                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input
                            type="text"
                            name="address"
                            class="form-control"
                            value="{{ old('address', $settings->address) }}"
                            maxlength="180"
                            placeholder="Street address"
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input
                            type="text"
                            name="city"
                            class="form-control"
                            value="{{ old('city', $settings->city) }}"
                            maxlength="80"
                            placeholder="Riyadh"
                        >
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <input
                            type="text"
                            name="country"
                            class="form-control"
                            value="{{ old('country', $settings->country) }}"
                            maxlength="80"
                            placeholder="Saudi Arabia"
                        >
                    </div>
                </div>
            </div>

            <div class="premium-card p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="icon-pill">
                        <i class="bi bi-receipt"></i>
                    </div>

                    <div>
                        <h3 class="mb-1">Invoice Settings</h3>
                        <p class="text-muted mb-0">Configure VAT and invoice note defaults.</p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">VAT Rate %</label>
                        <input
                            type="number"
                            name="vat_rate"
                            class="form-control"
                            value="{{ old('vat_rate', $settings->vat_rate) }}"
                            min="0"
                            max="100"
                            step="0.01"
                            required
                        >
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Invoice Note</label>
                        <textarea
                            name="invoice_note"
                            class="form-control"
                            rows="3"
                            maxlength="500"
                            placeholder="Invoice footer note"
                        >{{ old('invoice_note', $settings->invoice_note) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="premium-card p-4 mb-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="icon-pill">
                        <i class="bi bi-telephone"></i>
                    </div>

                    <div>
                        <h3 class="mb-1">Contact</h3>
                        <p class="text-muted mb-0">Customer-facing contact details.</p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $settings->email) }}"
                        maxlength="120"
                        placeholder="info@example.com"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ old('phone', $settings->phone) }}"
                        maxlength="40"
                        placeholder="0500000000"
                    >
                </div>

                <div class="mb-0">
                    <label class="form-label">WhatsApp</label>
                    <input
                        type="text"
                        name="whatsapp"
                        class="form-control"
                        value="{{ old('whatsapp', $settings->whatsapp) }}"
                        maxlength="40"
                        placeholder="0500000000"
                    >
                </div>
            </div>

            <div class="premium-card p-4">
                <h3 class="mb-2">Settings Preview</h3>
                <p class="text-muted mb-4">
                    These values will be used later in invoices and store-facing layouts.
                </p>

                <div class="side-item">
                    <span class="side-dot"></span>
                    Store: {{ $settings->store_name }}
                </div>

                <div class="side-item">
                    <span class="side-dot"></span>
                    VAT: {{ number_format((float) $settings->vat_rate, 2) }}%
                </div>

                <div class="side-item">
                    <span class="side-dot"></span>
                    Business: {{ $settings->business_name ?? 'Not set' }}
                </div>

                <div class="side-item">
                    <span class="side-dot"></span>
                    VAT No: {{ $settings->vat_number ?? 'Not set' }}
                </div>

                <div class="d-grid mt-4">
                    <button class="btn btn-primary btn-lg">
                        <i class="bi bi-save me-1"></i> Save Settings
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection