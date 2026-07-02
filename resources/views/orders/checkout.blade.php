@extends('layouts.app')

@section('title', 'Checkout - GameGrid')

@section('content')
    <div class="py-5">
        <div class="container-custom">
            <h1 class="mb-4">Secure Checkout</h1>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Order Details -->
                    <div class="col-lg-8 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Shipping Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="delivery_city" class="form-label">Delivery City</label>
                                    <input type="text" class="form-control @error('delivery_city') is-invalid @enderror" name="delivery_city" id="delivery_city" value="{{ old('delivery_city', session('selected_city')) }}" placeholder="Karachi, Lahore, Islamabad">
                                    @error('delivery_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Shipping Address</label>
                                    <textarea class="form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" id="shipping_address" rows="4" required>{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="delivery_notes" class="form-label">Delivery Notes</label>
                                    <textarea class="form-control @error('delivery_notes') is-invalid @enderror" name="delivery_notes" id="delivery_notes" rows="3" placeholder="Apartment, landmark, timing instructions">{{ old('delivery_notes') }}</textarea>
                                    @error('delivery_notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" required value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="button" class="btn btn-outline-primary mb-2" id="useGpsBtn">
                                    <i class="fas fa-location-crosshairs"></i> Use GPS City
                                </button>
                                <p class="small text-muted mb-0">GPS detection maps your coordinates to the closest supported city.</p>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Payment Method</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_card" value="card" checked>
                                    <label class="form-check-label" for="payment_card">
                                        <i class="fas fa-credit-card"></i> Credit/Debit Card
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_transfer" value="transfer">
                                    <label class="form-check-label" for="payment_transfer">
                                        <i class="fas fa-bank"></i> Bank Transfer
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod">
                                    <label class="form-check-label" for="payment_cod">
                                        <i class="fas fa-money-bill"></i> Cash on Delivery
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h4 class="mb-4">Order Summary</h4>
                            
                            @foreach($cart->items as $item)
                                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                    <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                    <span>Rs. {{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach

                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rs. {{ number_format($cart->getTotal(), 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>Rs. 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span>Tax:</span>
                                <span>Rs. 0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4" style="font-size: 1.2rem;">
                                <strong>Total:</strong>
                                <strong>Rs. {{ number_format($cart->getTotal(), 2) }}</strong>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-check"></i> Place Order
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-secondary w-100">
                                Edit Cart
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const useGpsBtn = document.getElementById('useGpsBtn');
        const cityField = document.getElementById('delivery_city');

        if (!useGpsBtn) {
            return;
        }

        useGpsBtn.addEventListener('click', function () {
            if (!window.isSecureContext) {
                alert('GPS detection requires HTTPS or localhost. Please open this site in a secure context.');
                return;
            }

            if (!navigator.geolocation) {
                alert('Geolocation is not supported in this browser.');
                return;
            }

            useGpsBtn.disabled = true;
            useGpsBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Detecting...';

            navigator.geolocation.getCurrentPosition(function (position) {
                fetch('{{ route('location.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    })
                }).then(function (response) {
                    if (!response.ok) {
                        throw new Error('Could not update delivery city.');
                    }

                    cityField.value = cityField.value || '{{ session('selected_city', '') }}';
                    window.location.reload();
                }).catch(function () {
                    alert('Failed to save GPS location. Please try again.');
                    useGpsBtn.disabled = false;
                    useGpsBtn.innerHTML = 'Use GPS for City';
                });
            }, function (error) {
                let message = 'Could not access your GPS location.';

                if (error && error.code === 1) {
                    message = 'Location permission denied. Please allow location access and try again.';
                } else if (error && error.code === 2) {
                    message = 'Location information is unavailable right now. Please try again.';
                } else if (error && error.code === 3) {
                    message = 'Location request timed out. Please try again.';
                }

                alert(message);
                useGpsBtn.disabled = false;
                useGpsBtn.innerHTML = 'Use GPS for City';
            }, { enableHighAccuracy: true, timeout: 10000 });
        });
    </script>
@endsection
