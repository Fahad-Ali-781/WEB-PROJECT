@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order #{{ $order->id }}</h1>

    <div class="mb-3">
        <strong>User:</strong> {{ optional($order->user)->name }} ({{ optional($order->user)->email }})
    </div>

    <div class="mb-3">
        <strong>Total:</strong> {{ number_format($order->total,2) }}
    </div>

    <div class="mb-3">
        <strong>Status:</strong>
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <select name="status" class="form-select d-inline-block w-auto">
                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary btn-sm">Update</button>
        </form>
    </div>

    <h4>Items</h4>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->quantity }}× {{ optional($item->product)->name }} — {{ number_format($item->price,2) }}</li>
        @endforeach
    </ul>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
