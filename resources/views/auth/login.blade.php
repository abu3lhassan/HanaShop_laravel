@extends('layouts.app')

@section('content')
<div class="container">
    <div class="auth-card premium-card">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark">H</span>
                <span>HanaShop</span>
            </a>

            <span class="status">Admin Area</span>
        </div>

        <span class="eyebrow">Secure Access</span>
        <h1 class="premium-title mb-2">Admin Login</h1>
        <p class="text-muted">
            Access the HanaShop dashboard to manage products, product details, customers, and invoices.
        </p>

        @if(session('status'))
            <div class="alert alert-success rounded-4 border-0 shadow-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email Address</label>
                <input
                    id="email"
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="admin@hanashop.test"
                    required
                    autocomplete="email"
                    autofocus
                >

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input
                    id="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="Enter password"
                    required
                    autocomplete="current-password"
                >

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex align-items-center justify-content-between gap-3 mb-4 flex-wrap">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                @if (Route::has('password.request'))
                    <a class="fw-bold text-decoration-none" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    Login to Dashboard
                </button>

                <a href="{{ route('index') }}" class="btn btn-soft">
                    Back to Store
                </a>
            </div>
        </form>

        <div class="mt-4 pt-3 border-top">
            <div class="d-flex gap-2 flex-wrap">
                <span class="status">Products</span>
                <span class="status">Customers</span>
                <span class="status">Invoices</span>
            </div>
        </div>
    </div>
</div>
@endsection