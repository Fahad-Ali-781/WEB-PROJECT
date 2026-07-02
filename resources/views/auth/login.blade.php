@extends('layouts.app')

@section('title', 'Login - EShop')

@section('content')
    <div class="py-5">
        <div class="container-custom">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Login to EShop</h4>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $googleLoginEnabled = config('services.google.client_id') && config('services.google.client_secret');
                                $facebookLoginEnabled = config('services.facebook.client_id') && config('services.facebook.client_secret');
                            @endphp

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" id="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           name="password" id="password" required>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>
                            </form>

                            @if ($googleLoginEnabled || $facebookLoginEnabled)
                                <div class="d-grid gap-2 mb-3">
                                    @if ($googleLoginEnabled)
                                        <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="btn btn-outline-primary">
                                            Continue with Google
                                        </a>
                                    @endif
                                    @if ($facebookLoginEnabled)
                                        <a href="{{ route('social.redirect', ['provider' => 'facebook']) }}" class="btn btn-outline-dark">
                                            Continue with Facebook
                                        </a>
                                    @endif
                                </div>
                            @endif

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="btn btn-link d-block text-center mb-2">
                                    Forgot Password?
                                </a>
                            @endif

                            <hr>

                            <p class="text-center">
                                Don't have an account? 
                                <a href="{{ route('register') }}">Register here</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
