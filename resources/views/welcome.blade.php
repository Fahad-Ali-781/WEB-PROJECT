@extends('layouts.app')

@php
    $featuredProducts = collect();
    $categories = collect();

    if (\Illuminate\Support\Facades\Schema::hasTable('products')) {
        $featuredProducts = \App\Models\Product::with('category')
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();
    }

    if (\Illuminate\Support\Facades\Schema::hasTable('categories')) {
        $categories = \App\Models\Category::withCount('products')
            ->whereIn('slug', ['pcs', 'tvs', 'laptops', 'consoles', 'accessories'])
            ->get();

        if ($categories->isEmpty()) {
            $categories = \App\Models\Category::withCount('products')->take(6)->get();
        }
    }
@endphp

@section('title', 'Gaming E-Commerce Store')

@section('styles')
<style>
    .hero {
        background: linear-gradient(125deg, #111827 0%, #1f2937 45%, #0d9488 100%);
        color: #fff;
        padding: 110px 0 90px;
        position: relative;
        overflow: hidden;
    }

    .hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(255,255,255,.22), transparent 35%);
        pointer-events: none;
    }

    .hero-panel {
        position: relative;
        z-index: 1;
        max-width: 720px;
        margin: 0 auto;
        text-align: center;
    }

    .hero-kicker {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .5rem 1rem;
        border-radius: 999px;
        background: rgba(255,255,255,.15);
        backdrop-filter: blur(8px);
        font-weight: 600;
        margin-bottom: 1.25rem;
    }

    .hero h1 {
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 800;
        line-height: 1.05;
        margin-bottom: 1rem;
    }

    .hero p {
        font-size: 1.1rem;
        max-width: 58rem;
        margin: 0 auto 2rem;
        opacity: .95;
    }

    .feature-chip {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .6rem 1rem;
        border-radius: 999px;
        background: #fff;
        color: #2C3E50;
        font-weight: 600;
        box-shadow: 0 12px 30px rgba(0,0,0,.12);
    }

    .section-shell {
        padding: 4rem 0;
    }

    .soft-card {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 14px 30px rgba(44, 62, 80, .08);
        border: 1px solid rgba(44,62,80,.06);
        height: 100%;
    }

    .category-card {
        padding: 1.5rem;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(44,62,80,.12);
    }

    .icon-badge {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, rgba(31,41,55,.12), rgba(13,148,136,.18));
        color: #0d9488;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }
</style>
@endsection

@section('content')
<section class="hero">
    <div class="container-custom">
        <div class="hero-panel">
            <div class="hero-kicker">
                <i class="fas fa-gamepad"></i>
                Gear up for next-level play
            </div>
            <h1>Gaming gear for every setup</h1>
            <p>Build your dream battle station with high-performance PCs, immersive TVs, powerful laptops, consoles, and pro-grade accessories.</p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Browse Products</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Create Account</a>
            </div>
            <div class="mt-4 d-flex flex-wrap justify-content-center gap-3">
                @php
                    $shopCategories = [
                        'Gaming PCs',
                        'Gaming Consoles',
                        'Gaming Mouse',
                        'Gaming Keyboards',
                        'Gaming Controllers',
                        'Gaming TVs',
                    ];
                @endphp

                @foreach($shopCategories as $shopCategory)
                    <span class="feature-chip">
                        <i class="fas fa-tag"></i>
                        {{ $shopCategory }}
                    </span>
                @endforeach
            </div>

            <div class="soft-card mt-5 p-4 text-start bg-white text-dark">
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <h5 class="mb-2">Select your city</h5>
                        <p class="text-muted mb-3">Choose a city manually or use GPS to personalize product discovery.</p>
                        <form action="{{ route('location.store') }}" method="POST" class="row g-2">
                            @csrf
                            <div class="col-md-8">
                                <select name="city" class="form-select">
                                    <option value="">Use all cities</option>
                                    <option value="Karachi" {{ session('selected_city') === 'Karachi' ? 'selected' : '' }}>Karachi</option>
                                    <option value="Lahore" {{ session('selected_city') === 'Lahore' ? 'selected' : '' }}>Lahore</option>
                                    <option value="Islamabad" {{ session('selected_city') === 'Islamabad' ? 'selected' : '' }}>Islamabad</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-grid">
                                <button type="submit" class="btn btn-primary">Apply City</button>
                            </div>
                        </form>
                        <div class="d-grid mt-2">
                            <button type="button" class="btn btn-outline-primary" id="gpsCityBtn">
                                <i class="fas fa-location-crosshairs"></i> Detect City by GPS
                            </button>
                            <small id="gpsCityStatus" class="text-muted mt-2 d-block" aria-live="polite"></small>
                        </div>
                    </div>
                    <div class="col-md-4 d-grid gap-2">
                        <a href="{{ route('products.index', ['view' => 'trending']) }}" class="btn btn-outline-secondary">Trending Deals</a>
                        <a href="{{ route('qr.index') }}" class="btn btn-outline-secondary">QR Reader</a>
                        <a href="{{ route('tracking.index') }}" class="btn btn-outline-secondary">Order Tracking</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-shell">
    <div class="container-custom">
        <h2 class="section-title">Shop by Category</h2>
        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-md-6 col-lg-4">
                    <div class="soft-card category-card">
                        <div class="icon-badge">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <h5 class="mb-2">{{ $category->name }}</h5>
                        <p class="text-muted mb-3">{{ $category->description }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">{{ $category->products_count }} items</span>
                            <a href="{{ route('category.show', $category->slug) }}" class="btn btn-secondary btn-sm">Browse</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-shell pt-0">
    <div class="container-custom">
        <h2 class="section-title">Featured Products</h2>
        <div class="row g-4">
            @forelse($featuredProducts as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=1200&q=80';">
                        </div>
                        <div class="product-info">
                            <span class="category-badge">{{ $product->category->name ?? 'Product' }}</span>
                            <h5 class="product-name">{{ $product->name }}</h5>
                            <p class="text-muted">{{ \Illuminate\Support\Str::limit($product->description, 95) }}</p>
                            <div class="product-price">Rs. {{ number_format($product->price, 2) }}</div>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">No featured products are available yet.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="section-shell pt-0">
    <div class="container-custom">
        <div class="soft-card p-4 p-lg-5 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
            <div>
                <h3 class="mb-2">Ready to upgrade your setup?</h3>
                <p class="mb-0 text-muted">From streaming-ready PCs to ultra-low-latency displays, discover hardware tuned for esports, content creation, and immersive gameplay.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Explore Gaming Store</a>
        </div>
    </div>
</section>

<script>
    (function () {
        const gpsCityBtn = document.getElementById('gpsCityBtn');
        const gpsCityStatus = document.getElementById('gpsCityStatus');
        const citySelect = document.querySelector('select[name="city"]');
        const defaultBtnHtml = '<i class="fas fa-location-crosshairs"></i> Detect City by GPS';

        if (!gpsCityBtn) {
            return;
        }

        function setStatus(message, type) {
            if (!gpsCityStatus) {
                return;
            }

            gpsCityStatus.textContent = message || '';
            gpsCityStatus.classList.remove('text-muted', 'text-danger', 'text-success');

            if (type === 'error') {
                gpsCityStatus.classList.add('text-danger');
            } else if (type === 'success') {
                gpsCityStatus.classList.add('text-success');
            } else {
                gpsCityStatus.classList.add('text-muted');
            }
        }

        function setLoading(isLoading) {
            gpsCityBtn.disabled = isLoading;
            gpsCityBtn.innerHTML = isLoading
                ? '<i class="fas fa-spinner fa-spin"></i> Detecting...'
                : defaultBtnHtml;
        }

        gpsCityBtn.addEventListener('click', function () {
            if (!window.isSecureContext) {
                alert('GPS detection requires HTTPS or localhost. Please open this site in a secure context.');
                return;
            }

            if (!navigator.geolocation) {
                alert('Geolocation is not supported in your browser.');
                return;
            }

            setLoading(true);
            setStatus('Requesting location permission...', 'info');

            navigator.geolocation.getCurrentPosition(function (position) {
                setStatus('Location found. Matching nearest city...', 'info');

                fetch('{{ route('location.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    })
                }).then(function (response) {
                    if (!response.ok) {
                        throw new Error('Could not update your city.');
                    }

                    return response.json();
                }).then(function (data) {
                    if (data && data.city && citySelect) {
                        citySelect.value = data.city;
                    }

                    const cityText = data && data.city ? data.city : 'your nearest city';
                    setStatus('Detected city: ' + cityText + '. Applied successfully.', 'success');
                    setLoading(false);
                }).catch(function () {
                    alert('Failed to save GPS location. Please try again.');
                    setStatus('Failed to detect or save location. Please try again.', 'error');
                    setLoading(false);
                });
            }, function (error) {
                let message = 'Could not detect your location.';

                if (error && error.code === 1) {
                    message = 'Location permission denied. Please allow location access and try again.';
                } else if (error && error.code === 2) {
                    message = 'Location information is unavailable right now. Please try again.';
                } else if (error && error.code === 3) {
                    message = 'Location request timed out. Please try again.';
                }

                alert(message);
                setStatus(message, 'error');
                setLoading(false);
            }, { enableHighAccuracy: true, timeout: 10000 });
        });
    })();
</script>
@endsection