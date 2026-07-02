@extends('layouts.app')

@section('title', 'My Account - GameGrid')

@section('content')
    <div class="page-shell">
        <div class="container-custom">
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <div class="card p-4">
                        <h3 class="mb-3">Profile</h3>
                        <form action="{{ route('account.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Update Profile</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-7 mb-4">
                    <div class="card p-4 mb-4">
                        <h3 class="mb-3">Favorite Products</h3>
                        @forelse($user->favorites as $favorite)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <div>
                                    <strong>{{ $favorite->product->name }}</strong>
                                    <div class="text-muted">{{ $favorite->product->category->name }}</div>
                                </div>
                                <a href="{{ route('products.show', $favorite->product->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No favorites yet.</p>
                        @endforelse
                    </div>

                    <div class="card p-4 mb-4">
                        <h3 class="mb-3">My Reviews</h3>
                        @forelse($user->reviews as $review)
                            <div class="border-bottom py-2">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $review->product->name }}</strong>
                                    <span class="badge bg-primary">{{ $review->rating }}/5</span>
                                </div>
                                <p class="mb-0 text-muted">{{ $review->comment ?: 'No comment provided.' }}</p>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No reviews yet.</p>
                        @endforelse
                    </div>

                    <div class="card p-4">
                        <h3 class="mb-3">Recent Orders</h3>
                        @forelse($user->orders->take(5) as $order)
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Order #{{ $order->id }}</span>
                                <span>Rs. {{ number_format($order->total, 2) }}</span>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No orders yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection