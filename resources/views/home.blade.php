@extends('layouts.app')
@section('content')
<div class="premium-card p-4"><h1 class="premium-title">Welcome to HanaShop</h1><p class="text-secondary mb-4">Open the dashboard to manage your store.</p><a class="btn btn-primary" href="{{ route('dashboard') }}">Go to Dashboard</a></div>
@endsection
