@extends('layouts.app')

@section('title', 'Gaming Products - GameGrid')

@section('content')
    <div class="page-shell">
        <div class="container-custom">
            @php
                $activeCity = request()->has('city') ? request('city') : ($selectedCity ?? '');
                $currentFilters = request()->except(['page', 'view', 'featured', 'clear_city', 'city']);

                if (!empty($activeCity)) {
                    $currentFilters['city'] = $activeCity;
                }

                $clearCityFilters = request()->except(['page', 'city', 'clear_city']);
                $clearCityFilters['clear_city'] = 1;
            @endphp

            <h1 class="mb-4">
                @if(isset($category))
                    {{ $category->name }} Gear
                @else
                    All Gaming Products
                @endif
            </h1>

            @if(!empty($selectedCity))
                <div class="alert alert-info d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span><i class="fas fa-location-dot"></i> Browsing in: <strong>{{ $selectedCity }}</strong></span>
                    <a href="{{ route('products.index', $clearCityFilters) }}" class="btn btn-sm btn-outline-secondary">Clear City Filter</a>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('products.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-lg-3">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="q" placeholder="Search products, cities..." value="{{ request('q') }}">
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">City</label>
                            <select name="city" class="form-select">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ $activeCity === $city ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Min Price</label>
                            <input type="number" name="min_price" class="form-control" value="{{ request('min_price') }}" placeholder="0">
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label">Max Price</label>
                            <input type="number" name="max_price" class="form-control" value="{{ request('max_price') }}" placeholder="100000">
                        </div>
                        <div class="col-lg-3 d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                            <button type="submit" id="featuredBtn" name="featured" value="1" class="btn btn-outline-primary">Featured</button>
                            <button type="submit" name="view" value="trending" class="btn btn-outline-secondary">Trending</button>
                            <a href="{{ route('products.index', ['clear_city' => 1]) }}" class="btn btn-outline-danger">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="mb-3">News Feed</h5>
                            <p class="text-muted mb-3">Featured gaming deals near your selected city.</p>
                            @foreach($featuredProducts->take(3) as $deal)
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <span>{{ $deal->name }}</span>
                                    <span class="text-muted">{{ $deal->city ?? 'Any city' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="mb-3">Trending</h5>
                            <p class="text-muted mb-3">Most ordered items in the catalog.</p>
                            @foreach($trendingProducts->take(3) as $trend)
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <span>{{ $trend->name }}</span>
                                    <span class="text-muted">Orders: {{ $trend->order_items_count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Gaming Categories</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('products.index') }}" class="d-block mb-2">
                                All Gaming Products
                            </a>
                            <a href="{{ route('products.index', array_merge($currentFilters, ['view' => 'trending'])) }}" class="d-block mb-2">
                                Trending Deals
                            </a>
                            <a href="{{ route('products.index', array_merge($currentFilters, ['featured' => 1])) }}" class="d-block mb-2">
                                Featured Deals
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('category.show', $cat->slug) }}" class="d-block mb-2">
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    @if($products->count() > 0)
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="product-card">
                                        <div class="product-image">
                                            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=1200&q=80';">
                                        </div>
                                        <div class="product-info">
                                            <h5 class="product-name">{{ $product->name }}</h5>
                                            <span class="category-badge">{{ $product->category->name }}</span>
                                            @if($product->city)
                                                <div class="text-muted mb-1"><i class="fas fa-location-dot"></i> {{ $product->city }}</div>
                                            @endif
                                            <div class="product-price">Rs. {{ number_format($product->price, 2) }}</div>
                                            <div class="product-rating mb-3">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm w-100">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle"></i>
                                    @if(request('featured') === '1')
                                        @php
                                            $msgParts = [];
                                        @endphp
                                        No featured products match your current filters.
                                        @if(!empty($featuredCityCount))
                                            <br>The selected city ({{ $selectedCity }}) has {{ $featuredCityCount }} featured product(s), but they do not match your other filters (search/price).
                                        @elseif(!empty($selectedCity))
                                            <br>The selected city ({{ $selectedCity }}) has no featured products.
                                        @endif
                                        <div class="mt-2">
                                            <a href="{{ route('products.index', ['featured' => 1]) }}" class="btn btn-sm btn-outline-primary">Show Featured (All Cities)</a>
                                            <a href="{{ route('products.index', array_merge(request()->except(['max_price','min_price','page']), ['max_price' => '', 'min_price' => ''])) }}" class="btn btn-sm btn-outline-secondary ms-2">Clear Price Filters</a>
                                            <a href="{{ route('products.index', array_merge(request()->except(['q','page']), ['q' => ''])) }}" class="btn btn-sm btn-outline-secondary ms-2">Clear Search</a>
                                        </div>
                                    @else
                                        <i class="fas fa-info-circle"></i> No products found.
                                    @endif
                                </div>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <h5 class="mb-1">Comparison mode</h5>
                            <p class="text-muted mb-0">Filter by price range and city to find the best match for your budget.</p>
                        </div>
                        <form action="{{ route('products.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-end">
                            <input type="hidden" name="q" value="{{ request('q') }}">
                            <select name="city" class="form-select">
                                <option value="">Any City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ $activeCity === $city ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="min_price" class="form-control" value="{{ request('min_price') }}" placeholder="Min">
                            <input type="number" name="max_price" class="form-control" value="{{ request('max_price') }}" placeholder="Max">
                            <button class="btn btn-secondary" type="submit">Compare</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        const featuredBtn = document.getElementById('featuredBtn');
        if (!featuredBtn) return;

        featuredBtn.addEventListener('click', function (e) {
            // Clear free-text search so Featured respects city & price only
            const form = featuredBtn.closest('form');
            if (!form) return;
            const qInput = form.querySelector('input[name="q"]');
            if (qInput) {
                qInput.value = '';
            }
            // allow submit to continue
        });
    })();
</script>
@endpush
