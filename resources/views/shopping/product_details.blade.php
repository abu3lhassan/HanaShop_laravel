@extends('layouts.appuserui')

@section('content')
<section class="section">
    <div class="container">
        <div class="hero-card">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="product-media slate" style="height:420px;@if(!empty($prod->image)) background-image:linear-gradient(135deg,rgba(15,23,42,.55),rgba(15,23,42,.15)),url('{{ $prod->image }}');background-size:cover;background-position:center; @endif">
                        @if(empty($prod->image))
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="4" y="5" width="16" height="12" rx="2"/><path d="M7 15l3-3 2 2 3-4 2 5"/></svg>
                        @endif
                        <span>{{ ucfirst($category ?? 'Product') }}</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="eyebrow">Product Details</span>
                    <h1 class="premium-title display-4">{{ $prod->name }}</h1>
                    <p class="lead text-secondary">{{ $prod->Description }}</p>
                    <div class="row g-3 my-4">
                        <div class="col-6"><div class="metric"><strong>${{ number_format((float) ($prod->price ?? 0), 0) }}</strong><span>Price</span></div></div>
                        <div class="col-6"><div class="metric"><strong>{{ $prod->qty ?? 0 }}</strong><span>Quantity</span></div></div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="pill">Color: {{ $prod->color ?? 'Premium' }}</span>
                        <a class="btn btn-primary" href="{{ route('index') }}">Back to Store</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
