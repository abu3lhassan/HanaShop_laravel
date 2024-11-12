@extends('layouts.appuserui')

@section('content')

<div class="container">
    <div class="row mt-5 text-center">
        <div class="col-md-4">
            <a href="{{ route('zena') }}" class="btn btn-primary w-100 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="bi bi-flower2 text-danger display-3"></i>
                        <h4 class="mt-3">Decor</h4>
                        <p class="text-muted">Add elegance to your space with our decor items.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('kitchenTools') }}" class="btn btn-primary w-100 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="bi bi-egg-fried text-success display-3"></i>
                        <h4 class="mt-3">Kitchen Tools</h4>
                        <p class="text-muted">Essentials for a well-equipped kitchen.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('electric') }}" class="btn btn-primary w-100 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="bi bi-phone-vibrate text-primary display-3"></i>
                        <h4 class="mt-3">Electronics</h4>
                        <p class="text-muted">Discover our range of electronics for all your needs.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection
