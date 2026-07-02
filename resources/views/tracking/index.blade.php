@extends('layouts.app')

@section('title', 'Track Order - GameGrid')

@section('content')
    <div class="page-shell">
        <div class="container-custom">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card p-4 mb-4">
                        <h1 class="mb-3">Track Your Order</h1>
                        <form method="GET" action="{{ route('tracking.index') }}" class="row g-3">
                            <div class="col-md-9">
                                <input type="text" name="tracking_key" class="form-control" placeholder="Enter tracking key" value="{{ request('tracking_key') }}" required>
                            </div>
                            <div class="col-md-3 d-grid">
                                <button type="submit" class="btn btn-primary">Track</button>
                            </div>
                        </form>
                    </div>

                    @if($order)
                        <div class="card p-4 mb-4">
                            <h4 class="mb-3">Order Found</h4>
                            <p><strong>Order #:</strong> {{ $order->id }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                            <p><strong>Tracking Key:</strong> {{ $order->tracking_key }}</p>
                            <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                            <div class="ratio ratio-16x9 my-3">
                                <iframe
                                    src="https://www.google.com/maps?q={{ urlencode($order->shipping_address) }}&output=embed"
                                    style="border:0;"
                                    allowfullscreen
                                    loading="lazy">
                                </iframe>
                            </div>
                            <a class="btn btn-outline-primary" target="_blank" href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->shipping_address) }}">Open in Google Maps</a>
                        </div>
                    @elseif(request()->filled('tracking_key'))
                        <div class="alert alert-warning">No order was found for that tracking key.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection