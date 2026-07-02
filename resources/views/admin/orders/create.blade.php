@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Order</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.orders.store') }}">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Select user --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">-- Select product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} — {{ number_format($product->price,2) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
        </div>

        <div class="mb-3">
            <label for="shipping_address" class="form-label">Shipping Address (optional)</label>
            <input type="text" name="shipping_address" id="shipping_address" class="form-control">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone (optional)</label>
            <input type="text" name="phone" id="phone" class="form-control">
        </div>

        <button class="btn btn-primary">Create Order</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
