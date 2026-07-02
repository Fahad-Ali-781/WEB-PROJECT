<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $order = null;

        if ($request->filled('tracking_key')) {
            $order = Order::with('items.product')->where('tracking_key', $request->get('tracking_key'))->first();
        }

        return view('tracking.index', compact('order'));
    }
}