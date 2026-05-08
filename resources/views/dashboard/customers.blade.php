@extends('layouts.appdash')

@section('content')
<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
    <div>
        <span class="eyebrow">Customers</span>
        <h1 class="premium-title mb-1">Customer Management</h1>
        <p class="text-muted mb-0">Review customer records and contact information in one organized workspace.</p>
    </div>

    <a class="btn btn-outline-dark" href="{{ route('dashboard') }}">Back to Dashboard</a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Total Customers</span>
            <strong>{{ $customers->count() }}</strong>
            <small>Registered records</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Data Type</span>
            <strong>Contacts</strong>
            <small>Name, email, phone, address</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="metric premium-card">
            <span class="metric-label">Module Status</span>
            <strong>Active</strong>
            <small>Customer list available</small>
        </div>
    </div>
</div>

<div class="premium-card p-3 p-lg-4">
    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
        <div>
            <h3 class="mb-1">Customer Records</h3>
            <p class="text-muted mb-0">Keep customer information visible for store follow-up and support.</p>
        </div>

        <span class="status">Customers</span>
    </div>

    <div class="table-responsive">
        <table class="table align-middle text-center mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-start">Name</th>
                    <th class="text-start">Email</th>
                    <th>Phone</th>
                    <th class="text-start">Address</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td class="fw-bold text-start">{{ $customer->name }}</td>
                        <td class="text-start">
                            @if(!empty($customer->email))
                                <a href="mailto:{{ $customer->email }}" class="text-decoration-none">
                                    {{ $customer->email }}
                                </a>
                            @else
                                <span class="text-muted">No email</span>
                            @endif
                        </td>
                        <td>{{ $customer->phone ?: 'No phone' }}</td>
                        <td class="text-start text-muted">{{ $customer->address ?: 'No address' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="py-5">
                                <h5 class="mb-1">No customers yet</h5>
                                <p class="text-muted mb-0">Customer records will appear here once added to the system.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection