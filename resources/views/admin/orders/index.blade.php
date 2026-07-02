@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex gap-2 mb-3 flex-wrap">
        <a href="{{ route('admin.orders.pending') }}" class="btn btn-warning">Pending Orders</a>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">Create Order</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Total</th>
                <th>Status</th>
                <th>Items</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ optional($order->user)->name }} ({{ optional($order->user)->email }})</td>
                <td>{{ number_format($order->total, 2) }}</td>
                <td>
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td>
                    @foreach($order->items as $item)
                        <div>{{ $item->quantity }}× {{ optional($item->product)->name }} @ {{ number_format($item->price,2) }}</div>
                    @endforeach
                </td>
                <td>{{ $order->created_at->toDayDateTimeString() }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    @if($order->status === 'pending')
                        <form action="{{ route('admin.orders.deliver', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark this order as delivered?')">Deliver</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection
