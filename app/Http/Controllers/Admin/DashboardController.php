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
        if(!checkPermission('view_dashboard'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try
        {
            $no_of_orders = Order::get()->count();
            $no_of_pending_orders = Order::where('status', 'Pending')->get()->count();
            $no_of_completed_orders = Order::where('status', 'Delivered')->get()->count();
            $no_of_cancelled_orders = Order::where('status', 'Cancelled')->get()->count();
            $total_sales = Order::where('status', 'Completed')->sum('total_amount');
            $orders_by_category_food = Order::whereHas('orderItems.product', function ($query) { $query->where('category_id', 1);})->count();
            $orders_by_category_nonFood = Order::whereHas('orderItems.product', function ($query) { $query->where('category_id', 2);})->count();
            $recentOrders = Order::latest()->take(5)->get();
            // dd($orders_by_category_nonFood);
            foreach($recentOrders as $recentOrder)
            {
                $user_id = $recentOrder->user_id;
                $user = User::find($user_id);
                $recentOrder["full_name"] = $user->full_name;
            }
            $orders = Order::orderBy('created_at', 'DESC')->get();
            return view('admin.dashboard', compact('total_sales', 
            'no_of_orders', 'no_of_pending_orders', 
            'no_of_completed_orders', 'no_of_cancelled_orders', 
            'recentOrders', 'orders_by_category_food', 'orders_by_category_nonFood', 'orders'));
        } catch(\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
