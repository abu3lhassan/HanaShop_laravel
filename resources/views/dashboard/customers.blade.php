@extends('layouts.appdash')

@section('content')
<div class="mb-4"><span class="eyebrow">Customers</span><h1 class="premium-title">Customer Management</h1></div>
<div class="premium-card p-3 p-lg-4"><div class="table-responsive"><table class="table align-middle text-center mb-0"><thead><tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th></tr></thead><tbody>@forelse($customers as $customer)<tr><td>{{ $customer->id }}</td><td class="fw-bold">{{ $customer->name }}</td><td>{{ $customer->email }}</td><td>{{ $customer->phone }}</td><td>{{ $customer->address }}</td></tr>@empty<tr><td colspan="5">No customers yet.</td></tr>@endforelse</tbody></table></div></div>
@endsection
