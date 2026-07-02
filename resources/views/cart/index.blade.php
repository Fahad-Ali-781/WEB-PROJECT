@extends('layouts.app')

@section('title', 'Shopping Cart - GameGrid')

@section('content')
    <div class="py-5">
        <div class="container-custom">
            <h1 class="mb-4">Your Gaming Cart</h1>

            @if($cart && $cart->items->count() > 0)
                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-lg-8 mb-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->items as $item)
                                        <tr>
                                            <td>
                                                <a href="{{ route('products.show', $item->product->id) }}" class="text-decoration-none">
                                                    {{ $item->product->name }}
                                                </a>
                                            </td>
                                            <td>Rs. {{ number_format($item->product->price, 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group" style="width: 100px;">
                                                        <input type="number" class="form-control" name="quantity" value="{{ $item->quantity }}" min="1" onchange="this.form.submit();">
                                                    </div>
                                                </form>
                                            </td>
                                            <td>Rs. {{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h4 class="mb-4">Order Summary</h4>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rs. {{ number_format($cart->getTotal(), 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>Rs. 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax:</span>
                                <span>Rs. 0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4" style="font-size: 1.2rem;">
                                <strong>Total:</strong>
                                <strong>Rs. {{ number_format($cart->getTotal(), 2) }}</strong>
                            </div>
                            <a href="{{ route('checkout') }}" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-credit-card"></i> Proceed to Checkout
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary w-100">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-shopping-cart"></i> Your cart is empty.
                    <br>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
