@extends('layouts.app')

@section('title', 'Order #' . $order->id . ' - GameGrid')

@section('content')
    <div class="py-5">
        <div class="container-custom">
            @php
                $statusLabels = [
                    'pending' => ['label' => 'Pending', 'class' => 'warning'],
                    'processing' => ['label' => 'Processing', 'class' => 'info'],
                    'shipped' => ['label' => 'Shipped', 'class' => 'primary'],
                    'delivered' => ['label' => 'Delivered', 'class' => 'success'],
                    'cancelled' => ['label' => 'Cancelled', 'class' => 'danger'],
                ];
                $status = $statusLabels[$order->status] ?? $statusLabels['cancelled'];
            @endphp

            <div class="row">
                <div class="col-lg-8">
                    <h1 class="mb-4">Order #{{ $order->id }}</h1>

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Order Status</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">
                                <strong>Status:</strong>
                                <span class="badge bg-{{ $status['class'] }}">{{ $status['label'] }}</span>
                            </p>
                            <p class="mb-0 mt-2"><strong>Tracking Key:</strong> {{ $order->tracking_key ?? 'Not generated yet' }}</p>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Order Details</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>Rs. {{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>Rs. {{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Shipping Information</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                            <p><strong>Delivery City:</strong> {{ $order->delivery_city ?? 'Not specified' }}</p>
                            <p><strong>Delivery Notes:</strong> {{ $order->delivery_notes ?? 'None' }}</p>
                            <p><strong>Phone:</strong> {{ $order->phone }}</p>
                            <p class="mb-0"><strong>Payment Method:</strong> 
                                @if($order->payment_method == 'card')
                                    Credit/Debit Card
                                @elseif($order->payment_method == 'transfer')
                                    Bank Transfer
                                @else
                                    Cash on Delivery
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h4 class="mb-4">Order Total</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>Rs. {{ number_format($order->total, 2) }}</span>
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
                        <div class="d-flex justify-content-between" style="font-size: 1.2rem;">
                            <strong>Total:</strong>
                            <strong>Rs. {{ number_format($order->total, 2) }}</strong>
                        </div>
                        <hr>
                        <p class="text-muted small">
                            <i class="fas fa-info-circle"></i> Order Date: {{ $order->created_at->format('M d, Y H:i') }}
                        </p>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-receipt"></i> Payment Ref: {{ $order->payment_reference ?? 'Not generated' }}
                        </p>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary w-100">
                            Back to Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
