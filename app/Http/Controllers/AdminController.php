<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    
    public function index(){
        $users = User::all(); // Отримуємо всіх користувачів
        return view('user.admin.list', compact('users'));
    }

    public function dashboard (){
        return view('user.admin.dashboard');
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:new,processing,completed,canceled',
        ]);

        $order = Order::findOrFail($orderId);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Статус замовлення оновлено!');
    }
}
