@extends('layouts.app')

@section('title', 'My Orders - GameGrid')

@section('content')
    <div class="py-5">
        <div class="container-custom">
            <h1 class="mb-4">My Gaming Orders</h1>

            @php
                $statusLabels = [
                    'pending' => ['label' => 'Pending', 'class' => 'warning'],
                    'processing' => ['label' => 'Processing', 'class' => 'info'],
                    'shipped' => ['label' => 'Shipped', 'class' => 'primary'],
                    'delivered' => ['label' => 'Delivered', 'class' => 'success'],
                    'cancelled' => ['label' => 'Cancelled', 'class' => 'danger'],
                ];
            @endphp

            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Payment Ref</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>Rs. {{ number_format($order->total, 2) }}</td>
                                    <td>
                                        {{ $order->payment_reference ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @php $status = $statusLabels[$order->status] ?? $statusLabels['cancelled']; @endphp
                                        <span class="badge bg-{{ $status['class'] }}">{{ $status['label'] }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> You haven't placed any orders yet.
                    <br>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
