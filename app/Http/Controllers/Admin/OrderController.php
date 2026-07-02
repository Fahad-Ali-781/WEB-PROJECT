<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::with('user', 'items')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function pending()
    {
        $orders = Order::with('user', 'items')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders.pending', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('admin.orders.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $quantity = (int) $validated['quantity'];

        $total = $product->price * $quantity;

        $order = Order::create([
            'user_id' => $validated['user_id'],
            'total' => $total,
            'status' => 'pending',
            'shipping_address' => $validated['shipping_address'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $product->price,
            'quantity' => $quantity,
        ]);

        // reduce stock if stock column exists
        if (isset($product->stock)) {
            $product->decrement('stock', $quantity);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully.');
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->status = $validated['status'];
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated.');
    }

    public function deliver(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('admin.orders.pending')->with('error', 'Only pending orders can be marked as delivered.');
        }

        $order->status = 'delivered';
        $order->save();

        return redirect()->route('admin.orders.pending')->with('success', 'Order marked as delivered.');
    }
}
