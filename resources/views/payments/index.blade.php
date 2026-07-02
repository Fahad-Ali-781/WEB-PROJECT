@extends('layouts.app')

@section('title', 'Payment History - GameGrid')

@section('content')
    <div class="py-5">
        <div class="container-custom">
            <h1 class="mb-4">Payment History</h1>

            @php
                $statusLabels = [
                    'pending' => ['label' => 'Pending', 'class' => 'warning'],
                    'processing' => ['label' => 'Processing', 'class' => 'info'],
                    'shipped' => ['label' => 'Shipped', 'class' => 'primary'],
                    'delivered' => ['label' => 'Delivered', 'class' => 'success'],
                    'cancelled' => ['label' => 'Cancelled', 'class' => 'danger'],
                ];
            @endphp

            @if($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Order</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Method</th>
                                <th>Order Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_reference ?? 'N/A' }}</td>
                                    <td>#{{ $payment->id }}</td>
                                    <td>{{ optional($payment->paid_at ?? $payment->created_at)->format('M d, Y') }}</td>
                                    <td>Rs. {{ number_format($payment->total, 2) }}</td>
                                    <td>{{ ucfirst($payment->payment_method) }}</td>
                                    <td>
                                        @php $status = $statusLabels[$payment->status] ?? $statusLabels['cancelled']; @endphp
                                        <span class="badge bg-{{ $status['class'] }}">{{ $status['label'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $payments->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center">No payment records found yet.</div>
            @endif
        </div>
    </div>
@endsection