<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart;
        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }
        $cart->load('items.product');

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Requested quantity is not available in stock.');
        }

        $cart = Auth::user()->cart;

        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $validated['quantity'];

            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Cannot add more than available stock.');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
            ]);
        }

        return back()->with('success', 'Gaming item added to cart!');
    }

    public function remove(CartItem $item)
    {
        if (!$this->ownsCartItem($item)) {
            abort(403);
        }

        $item->delete();
        return back()->with('success', 'Item removed from cart!');
    }

    public function update(Request $request, CartItem $item)
    {
        if (!$this->ownsCartItem($item)) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($item->product && $validated['quantity'] > $item->product->stock) {
            return back()->with('error', 'Cannot set quantity higher than stock.');
        }

        $item->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Cart updated!');
    }

    public function clear()
    {
        if (Auth::check()) {
            $cart = Auth::user()->cart;
            if ($cart) {
                $cart->items()->delete();
            }
        }
        return back()->with('success', 'Cart cleared!');
    }

    private function ownsCartItem(CartItem $item): bool
    {
        return (int) $item->cart?->user_id === (int) Auth::id();
    }
}
