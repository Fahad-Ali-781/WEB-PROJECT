@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h1 class="mb-1">Pending Orders</h1>
            <p class="text-muted mb-0">Orders waiting for delivery.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to All Orders</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Items</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ optional($order->user)->name }}<br><small class="text-muted">{{ optional($order->user)->email }}</small></td>
                            <td>{{ number_format($order->total, 2) }}</td>
                            <td>
                                @foreach($order->items as $item)
                                    <div>{{ $item->quantity }}× {{ optional($item->product)->name }} @ {{ number_format($item->price, 2) }}</div>
                                @endforeach
                            </td>
                            <td>{{ $order->created_at->toDayDateTimeString() }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <form action="{{ route('admin.orders.deliver', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark this order as delivered?')">Mark Delivered</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $orders->links() }}
    @else
        <div class="alert alert-info">There are no pending orders right now.</div>
    @endif
</div>
@endsection