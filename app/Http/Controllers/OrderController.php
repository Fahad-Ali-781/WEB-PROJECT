<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = Auth::user()->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        return view('orders.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
            'delivery_city' => 'nullable|string|max:100',
            'delivery_notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:card,transfer,cod'
        ]);

        $cart = Auth::user()->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }

        $cart->load('items.product');

        foreach ($cart->items as $item) {
            if (!$item->product || $item->quantity > $item->product->stock) {
                return back()->with('error', 'One or more items are out of stock. Please update your cart.');
            }
        }

        $total = $cart->getTotal();

        $order = DB::transaction(function () use ($validated, $cart, $total) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
                'tracking_key' => strtoupper(Str::random(10)),
                'delivery_city' => $validated['delivery_city'] ?? null,
                'delivery_notes' => $validated['delivery_notes'] ?? null,
                'shipping_address' => $validated['shipping_address'],
                'phone' => $validated['phone'],
                'payment_method' => $validated['payment_method'],
                'payment_reference' => strtoupper(Str::random(12)),
                'paid_at' => in_array($validated['payment_method'], ['card', 'transfer'], true) ? now() : null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
    }
}
