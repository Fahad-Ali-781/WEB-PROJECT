@extends('layouts.app')

@section('title', 'Register - EShop')

@section('content')
    <div class="py-5">
        <div class="container-custom">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Create Account</h4>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $googleSignupEnabled = config('services.google.client_id') && config('services.google.client_secret');
                                $facebookSignupEnabled = config('services.facebook.client_id') && config('services.facebook.client_secret');
                            @endphp

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" id="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" id="email" value="{{ old('email') }}" required>
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

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" 
                                           name="password_confirmation" id="password_confirmation" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                    <i class="fas fa-user-plus"></i> Register
                                </button>
                            </form>

                            @if ($googleSignupEnabled || $facebookSignupEnabled)
                                <div class="d-grid gap-2 mb-3">
                                    @if ($googleSignupEnabled)
                                        <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="btn btn-outline-primary">
                                            Sign up with Google
                                        </a>
                                    @endif
                                    @if ($facebookSignupEnabled)
                                        <a href="{{ route('social.redirect', ['provider' => 'facebook']) }}" class="btn btn-outline-dark">
                                            Sign up with Facebook
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <hr>

                            <p class="text-center">
                                Already have an account? 
                                <a href="{{ route('login') }}">Login here</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
