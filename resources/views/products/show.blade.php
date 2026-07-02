@extends('layouts.app')

@section('title', $product->name . ' - GameGrid')

@section('content')
    <div class="page-shell">
        <div class="container-custom">
            <div class="row">
                <!-- Product Image -->
                <div class="col-md-5">
                    <div class="product-card">
                        <div class="product-image" style="height: 400px;">
                            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=1200&q=80';">
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-md-7">
                    <h1 class="mb-3">{{ $product->name }}</h1>
                    
                    <span class="category-badge">{{ $product->category->name }}</span>
                    
                    <div class="product-rating my-3">
                        @for($star = 1; $star <= 5; $star++)
                            <i class="fas fa-star{{ $product->average_rating >= $star ? '' : '-o' }}"></i>
                        @endfor
                        <span class="ms-2 text-muted">({{ $product->rating_count }} reviews)</span>
                    </div>

                    <div class="product-price mb-3" style="font-size: 2rem;">
                        Rs. {{ number_format($product->price, 2) }}
                    </div>

                    @if($product->stock > 0)
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }} available)
                        </div>
                    @else
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-times-circle"></i> Out of Stock
                        </div>
                    @endif

                    <p class="lead mb-4">{{ $product->description }}</p>

                    @auth
                        <div class="d-flex gap-2 mb-3">
                            <form action="{{ route('products.favorite', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-heart"></i> Favorite
                                </button>
                            </form>
                            <a href="{{ route('account') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-user"></i> My Account
                            </a>
                        </div>
                    @endauth

                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                                @csrf
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" id="decreaseBtn">-</button>
                                            <input type="number" class="form-control" id="quantityInput" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 60px;">
                                            <button class="btn btn-outline-secondary" type="button" id="increaseBtn">+</button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-primary btn-lg mt-3 w-100">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-4">
                            Login to Add to Cart
                        </a>
                    @endauth

                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Product Specs</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Product ID:</strong> #{{ $product->id }}</p>
                            <p><strong>Category:</strong> {{ $product->category->name }}</p>
                            <p><strong>Stock:</strong> {{ $product->stock }} units</p>
                            <p><strong>Added:</strong> {{ $product->created_at->format('M d, Y') }}</p>
                            <p><strong>Average Rating:</strong> {{ number_format($product->average_rating, 1) }}/5</p>
                        </div>
                    </div>

                    @auth
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Rate This Product</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('products.reviews.store', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Rating</label>
                                        <select name="rating" class="form-select" required>
                                            <option value="5">5 - Excellent</option>
                                            <option value="4">4 - Very Good</option>
                                            <option value="3">3 - Good</option>
                                            <option value="2">2 - Fair</option>
                                            <option value="1">1 - Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Comment</label>
                                        <textarea name="comment" class="form-control" rows="3" placeholder="Share your experience"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Rating</button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    @if($product->reviews->count() > 0)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Customer Reviews</h5>
                            </div>
                            <div class="card-body">
                                @foreach($product->reviews as $review)
                                    <div class="border-bottom pb-3 mb-3">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $review->user->name }}</strong>
                                            <span class="badge bg-primary">{{ $review->rating }}/5</span>
                                        </div>
                                        <p class="mb-0 mt-2">{{ $review->comment ?? 'No comment provided.' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-5">
                    <h3 class="mb-4">Related Products</h3>
                    <div class="row">
                        @foreach($relatedProducts as $related)
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="{{ $related->image ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $related->name }}">
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-name">{{ $related->name }}</h5>
                                        <div class="product-price">Rs. {{ number_format($related->price, 2) }}</div>
                                        <a href="{{ route('products.show', $related->id) }}" class="btn btn-primary btn-sm w-100">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('increaseBtn').addEventListener('click', function() {
            let input = document.getElementById('quantityInput');
            let max = parseInt(input.max);
            let current = parseInt(input.value);
            if(current < max) {
                input.value = current + 1;
            }
        });

        document.getElementById('decreaseBtn').addEventListener('click', function() {
            let input = document.getElementById('quantityInput');
            let current = parseInt(input.value);
            if(current > 1) {
                input.value = current - 1;
            }
        });
    </script>
@endsection
