<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Auth::user()->orders()->latest()->paginate(10);

        return view('payments.index', compact('payments'));
    }
}