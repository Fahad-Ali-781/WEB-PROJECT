<?php

namespace App\Http\Controllers;

use App\Models\Product;

class QrController extends Controller
{
    public function index()
    {
        $products = Product::visible()->with('category')->orderBy('id')->get();

        return view('qr.index', compact('products'));
    }
}