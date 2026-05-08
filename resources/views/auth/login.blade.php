@extends('layouts.app')

@section('content')
<div class="container">
    <div class="auth-card premium-card">
        <a class="brand" href="{{ url('/') }}"><span class="brand-mark">H</span><span>HanaShop</span></a>
        <h1 class="premium-title">Admin Login</h1>
        <p>Access the HanaShop dashboard to manage products, customers, and invoices.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="d-flex align-items-center justify-content-between gap-3 mb-4 flex-wrap">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="fw-bold" href="{{ route('password.request') }}">Forgot Password?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>
@endsection
