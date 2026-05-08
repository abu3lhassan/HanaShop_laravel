@extends('layouts.appdash')

@section('content')
<div class="mb-4"><span class="eyebrow">Invoices</span><h1 class="premium-title">Invoice Management</h1></div>
<div class="premium-card p-3 p-lg-4"><div class="table-responsive"><table class="table align-middle text-center mb-0"><thead><tr><th>#</th><th>Customer ID</th><th>Product ID</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead><tbody>@forelse($invoices as $invoice)<tr><td>{{ $invoice->id }}</td><td>{{ $invoice->costumer_id }}</td><td>{{ $invoice->products_id }}</td><td>{{ $invoice->qty }}</td><td>SAR {{ number_format($invoice->price, 2) }}</td><td class="fw-bold">SAR {{ number_format($invoice->total, 2) }}</td></tr>@empty<tr><td colspan="6">No invoices yet.</td></tr>@endforelse</tbody></table></div></div>
@endsection
