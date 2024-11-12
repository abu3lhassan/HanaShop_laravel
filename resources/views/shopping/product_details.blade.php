@extends('layouts.appuserui')

@section('content')

<section class="h-100 h-custom" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-8 col-xl-6">
        <div class="card border-top border-bottom border-3" style="border-color: #f37a27 !important;">
          <div class="card-body p-5">
            <p class="lead fw-bold mb-5" style="color: #f37a27;">Product Details</p>
            
            @if ($prod)
              <div class="text-center mb-4">
                <img src="{{ $prod->image }}" alt="Product Image" width="200" height="200" class="img-fluid">
              </div>
              <h3 class="mb-3">{{ $prod->name }}</h3>
              <p>{{ $prod->Description }}</p>
              <p>Color: {{ $prod->color }}</p>
              <p>Quantity Available: {{ $prod->qty }}</p>
              <p>Price: £{{ number_format($prod->price, 2) }}</p>
            @else
              <p>Product details not available.</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
