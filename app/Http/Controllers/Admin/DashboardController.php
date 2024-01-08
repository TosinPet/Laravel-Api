<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function dashboard()
    {
        try
        {
            $no_of_orders = Order::get()->count();
            $no_of_pending_orders = Order::where('status', 'Pending')->get()->count();
            $no_of_completed_orders = Order::where('status', 'Completed')->get()->count();
            $no_of_cancelled_orders = Order::where('status', 'Cancelled')->get()->count();
            $total_sales = Order::where('status', 'Completed')->sum('total_amount');
            $orders_by_category_food = Order::whereHas('orderItems.product', function ($query) { $query->where('category_id', 1);})->count();
            $orders_by_category_nonFood = Order::whereHas('orderItems.product', function ($query) { $query->where('category_id', 2);})->count();
            $percentage_orders_by_category_food = ($orders_by_category_food / $no_of_orders) * 100;
            $percentage_orders_by_category_nonFood = ($orders_by_category_nonFood / $no_of_orders) * 100;
            $recentOrders = Order::latest()->take(5)->get();
            // dd($recentOrders);
            foreach($recentOrders as $recentOrder)
            {
                $user_id = $recentOrder->user_id;
                $user = User::find($user_id);
                $recentOrder["full_name"] = $user->full_name;
            }
            // dd($orders);
            return view('admin.dashboard', compact('total_sales', 'no_of_orders', 'no_of_pending_orders', 'no_of_completed_orders', 'no_of_cancelled_orders', 'recentOrders'));
        } catch(\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
