<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportOrder;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CustomerAccount;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_orders'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $orders = Order::orderBy('created_at', 'DESC')->get();
        foreach($orders as $order)
        {
            $user_id = $order->user_id;
            $user = User::find($user_id);
            $order["full_name"] = $user->full_name;
        }
        return view('admin.order.index', compact('orders'));
    }

    public function showOrder(string $id)
    {
        if(!checkPermission('view_single_order'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        //
        $order_item = OrderItem::find($id);
        $order_items = OrderItem::where('order_id','=', $id)->get();
        $order = Order::find($id);
        // dd($order);

        foreach($order_items as $order_item)
        {
            $order_id = $order_item->order_id;  
            $order = Order::find($order_id);
        }
        foreach($order_items as $order_item)
        {
            $product_id = $order_item->product_id;
            $product = Product::find($product_id);
            $order_item['product_name'] = $product->name;
            $order_item['product_price'] = $product->price;
        }

        $user_id = $order->user_id;
        $user = User::find($user_id);
        $order['full_name'] = $user->full_name;

        $customer = Customer::where('user_id', '=', $user->id)->first();
        $customer_account = CustomerAccount::where('customer_id', '=', $customer->id)->first();

        // dd($order->full_name);
        return view('admin.order.show', compact('order', 'order_items', 'customer_account'));
    }

    public function approveOrder($id)
    {
        if(!checkPermission('approve_order'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try {
            $order = Order::find($id);
            $user_id = $order->user_id;
            $user = User::find($user_id);
            $customer = Customer::where('user_id', '=', $user->id)->first();
            $customer_account = CustomerAccount::where('customer_id', '=', $customer->id)->first();
            if($order->total_amount <= $customer_account->credit_allowance)
            {
                $order->update(['is_approved' => true]);
                return redirect()->back()->with('success', 'Order approved successfully');
            }else{
                return redirect()->back()->with('danger', 'Order cannot be approved');
            }
        } catch (ValidationException $th) 
        {
            return back()->with('danger', $th->validator->errors()->first())->withInput();
        } catch (\Throwable $th) 
        {
            return back()->with('danger', $th->getMessage())->withInput();
        }
    }

    public function exportOrder(Request $request)
    {
        if(!checkPermission('export_order'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try{
            return Excel::download(new ExportOrder, 'orders.xlsx');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first());
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());

        }
        
    }

    public function updateOrder(Request $request, string $id)
    {
        // dd($request);
        $this->validate($request, [
                'status' => 'required',
                'payment_status' => 'required',
            ]);
            // dd($request);

            $order = Order::find($id);

            $order->status = $request->status;
            $order->payment_status = $request->payment_status;
            // dd($order);
            $order->save();

            return redirect()->route('admin.order.index')->with('status',"Order has been edited successfully");
    }
}
