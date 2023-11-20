<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->get();
        foreach($orders as $order)
        {
            $user_id = $order->user_id;
            $user = User::find($user_id);
            $order["full_name"] = $user->full_name;
        }
        return view('admin.order.index', compact('orders'));
    }
}
