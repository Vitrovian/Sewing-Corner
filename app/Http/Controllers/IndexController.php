<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;   

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = Order::latest()->take(4)->get();

        return view('pages.index', compact('orders'));
    }
}
