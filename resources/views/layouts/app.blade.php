<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Commerce Store')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;800&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0f766e;
            --secondary: #334155;
            --accent: #f97316;
            --dark: #0f172a;
            --light: #e2e8f0;
            --surface: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(15,118,110,.12), transparent 30%),
                radial-gradient(circle at bottom right, rgba(249,115,22,.1), transparent 28%),
                var(--light);
            color: var(--dark);
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, #020617 0%, #0f172a 50%, #0f766e 100%);
            box-shadow: 0 10px 30px rgba(20, 33, 61, 0.18);
        }

        .navbar-brand {
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            font-size: 1.35rem;
            letter-spacing: .05em;
            color: white !important;
        }

        .nav-link {
            color: white !important;
            margin: 0 10px;
            transition: 0.3s;
        }

        .nav-link:hover {
            opacity: 0.8;
        }

        .hero {
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 55%, var(--secondary) 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: var(--primary) !important;
            border: none;
            padding: 10px 30px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #115e59 !important;
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(15, 118, 110, 0.28);
        }

        .btn-secondary {
            background-color: var(--secondary) !important;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #23948e !important;
            transform: translateY(-2px);
        }

        .product-card {
            background: var(--surface);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 30px rgba(20, 33, 61, 0.08);
            transition: 0.3s;
            height: 100%;
            border: 1px solid rgba(20, 33, 61, 0.05);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 45px rgba(20, 33, 61, 0.13);
        }

        .product-image {
            width: 100%;
            height: 250px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: rgba(20, 33, 61, 0.2);
            position: relative;
            overflow: hidden;
            padding: 14px;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            display: block;
        }

        .product-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(20,33,61,.02), rgba(20,33,61,.08));
            pointer-events: none;
        }

        .product-info {
            padding: 20px;
        }

        .product-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
            min-height: 40px;
        }

        .product-price {
            font-size: 1.5rem;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .product-rating {
            color: #FFC107;
            margin-bottom: 15px;
        }

        .footer {
            background: linear-gradient(135deg, #020617 0%, #0f172a 60%, #1e293b 100%);
            color: white;
            padding: 50px 0 20px;
            margin-top: 50px;
        }

        .footer h5 {
            color: #2dd4bf;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer a {
            color: #ccc;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer a:hover {
            color: #2dd4bf;
        }

        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 40px;
            text-align: center;
            font-family: 'Orbitron', sans-serif;
        }

        .category-badge {
            display: inline-block;
            padding: 5px 15px;
            background-color: #0f766e;
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .page-shell {
            padding-top: 1rem;
            padding-bottom: 2rem;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .cart-summary {
            background: var(--surface);
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 14px 30px rgba(20, 33, 61, 0.08);
        }

        .cart-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--primary);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-md navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-headset"></i> GameGrid
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tracking.index') }}">Track Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('qr.index') }}">QR Reader</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('payments.index') }}">Payments</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach($categories as $cat)
                                <li><a class="dropdown-item" href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> Cart
                            @auth
                                @if(auth()->user()->cart && auth()->user()->cart->items->count() > 0)
                                    <span class="badge bg-danger cart-badge">{{ auth()->user()->cart->items->count() }}</span>
                                @endif
                            @endauth
                        </a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('account') }}">My Account</a></li>
                                <li><a class="dropdown-item" href="{{ route('payments.index') }}">Payment History</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a></li>
                                @if(auth()->user()->is_admin ?? false)
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}">Admin Orders</a></li>
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('admin.orders.pending') }}">
                                            <span>Pending Orders</span>
                                            @if(($pendingOrdersCount ?? 0) > 0)
                                                <span class="badge bg-warning text-dark">{{ $pendingOrdersCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container-custom">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5>About GameGrid</h5>
                    <p>A gaming-first ecommerce store for PCs, TVs, laptops, consoles, and accessories.</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
                        <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Customer Service</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Shipping and Delivery</a></li>
                        <li><a href="#">Returns</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Follow Us</h5>
                    <a href="#" class="text-decoration-none"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-decoration-none ms-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-decoration-none ms-3"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <hr class="bg-white">
            <div class="text-center">
                <p>&copy; 2026 GameGrid. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
