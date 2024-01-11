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
use App\Models\Purchase;
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

    public function createOrder(Request $request)
    {
        if(!checkPermission('create_order'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('post'))
        {
            try
                {
                    // dd($request);
                    $request->validate([
                        'customer_id' => 'bail|required',
                        'skus' => 'bail|required|array|min:1',
                        'skus.*.sku_id' => 'bail|required',
                        'skus.*.quantity' => 'bail|required|integer|min:1',
                        'phone' => 'bail|required|string',
                        'order_date' => 'bail|required|string',
                        'shipping_address' => 'bail|string'
                    ]);
                    // dd($request);

                    $user = User::find($request->customer_id);
                    if (!$user) {
                        return redirect()->back()->with('danger', 'Invalid customer selected.');
                    }
                    // dd($user);
                    
                    $order_number = 'KIR'.random_int(1000000000, 9999999999);
            
                    $order = Order::create([
                        'user_id' => $request->customer_id,
                        'phone' => $request->phone,
                        'order_number' => $order_number,
                        'order_date' => $request->order_date,
                        'shipping_address' => $request->shipping_address,
                    ]);
                    // dd($order);
            
                    $totalAmount = 0;

                    foreach ($request->skus as $sku) {
                        $product = Product::find($sku['sku_id']);
                        // dd($product->quantity);
                        $unit_price = $product->price;
                        $quantity = $sku['quantity'];
                        // dd($quantity);
                        $total_price = $unit_price * $quantity;

                        $orderItem = OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'unit_price' => $unit_price,
                            'total_price' => $total_price
                        ]);
                        // dd($orderItem);

                        $totalAmount += $total_price;
                    }
            
                    $order->update(['total_amount' => $totalAmount]);  
                    return redirect()->back()->with('success', 'Order created successfully');

                } catch (ValidationException $e)
                {
                    return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
                } catch (\Exception $e)
                {
                    return redirect()->back()->with('danger', $e->getMessage())->withInput();
                }
            }else{
            try
                {
                    $customers = Customer::all();
                    $skus = Product::all();
                    return view('admin.order.create', compact('customers', 'skus'));
                } catch(\Exception $e)
                {
                    // dd($e->getMessage());
                    return redirect()->back()->with('danger', $e->getMessage());
                }
        }
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

    public function editOrder(Request $request, $order_id)
    {
        if(!checkPermission('edit_order'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('patch'))
        {
            try
            {   
                // dd($request);
                $this->validate($request, [
                    'customer_id' => 'bail|required',
                    'skus' => 'bail|required|array|min:1',
                    'skus.*.sku_id' => 'bail|required',
                    'skus.*.quantity' => 'bail|required|integer|min:1',
                    'phone' => 'bail|required|string',
                    'order_date' => 'bail|required|string',
                    'shipping_address' => 'bail|string'
                ]);
                // dd($request);

                $user = User::find($request->customer_id);
                if (!$user) {
                    return redirect()->back()->with('danger', 'Invalid customer selected.');
                }
                // dd($user);

                $order = Order::find($order_id);
                // dd($order);
                $orderItem = OrderItem::where('order_id', $order_id)->get();
                // dd($orderItem);
                
                $order_number = 'KIR'.random_int(1000000000, 9999999999);
        
                $order->update([
                    'user_id' => $request->customer_id,
                    'phone' => $request->phone,
                    'order_number' => $order_number,
                    'order_date' => $request->order_date,
                    'shipping_address' => $request->shipping_address,
                ]);
                // dd($order);
        
                $totalAmount = 0;

                foreach ($request->skus as $sku) {
                    // dd($sku);
                    $product = Product::find($sku['sku_id']);
                    $unit_price = $product->price;
                    $quantity = $sku['quantity'];
                    $total_price = $unit_price * $quantity;

                    $orderItem = OrderItem::where('order_id', $order->id)
                        ->where('product_id', $product->id)
                        ->first();

                    if ($orderItem) {
                        $orderItem->update([
                            'quantity' => $quantity,
                            'unit_price' => $unit_price,
                            'total_price' => $total_price,
                        ]);

                        $totalAmount += $total_price;
                    } else {
                        $newOrderItem = OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'unit_price' => $unit_price,
                            'total_price' => $total_price,
                        ]);
                
                        $totalAmount += $total_price;
                    }
                }
        
                $order->update(['total_amount' => $totalAmount]);  

                return redirect()->back()->with('success', 'Order edited successfully');

            } catch (ValidationException $e)
            {
                return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
            } catch (\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
        }else{
            try
            {
                $order = Order::findOrFail($order_id);
                $customers = Customer::all();
                $skus = Product::all();
    
                $orderItems = $order->orderItems;
    
                return view('admin.order.edit', compact('order', 'customers', 'skus', 'orderItems'));
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
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

    public function updateStatus(Request $request, string $id)
    {
        // dd($request);
        // if(!checkPermission('update_order'))
        // {
        //     return redirect()->back()->with('danger', 'Access Forbidden');
        // }
        // try {
        //     $this->validate($request, [
        //         'status' => 'required',
        //         'payment_status' => 'required',
        //     ]);
        //     // dd($request);

        //     $order = Order::find($id);

        //     $order->status = $request->status;
        //     $order->payment_status = $request->payment_status;
        //     // dd($order);
        //     $order->save();
        //     return redirect()->route('admin.order.index')->with('status',"Order has been edited successfully");
        // } catch (ValidationException $th) 
        // {
        //     return back()->with('danger', $th->validator->errors()->first())->withInput();
        // } catch (\Throwable $th) 
        // {
        //     return back()->with('danger', $th->getMessage())->withInput();
        // }
        if(!checkPermission('update_order_status'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $order = Order::findOrFail($id);

        switch ($order->status) {
            case 'Pending':
                $this->handlePendingStatus($request, $order);
                break;
            case 'Approved':
                $this->handleApprovedStatus($request, $order);
                break;
            case 'Paid':
                $this->handlePaidStatus($request, $order);
                break;
            // case 'Delivered':
            //     $this->handleDeliveredStatus($request, $order);
            //     break;
            // Add more cases as needed
        }

        return redirect()->route('admin.order.show', $order)->with('status', 'Order status updated successfully.');
    }

    private function handlePendingStatus(Request $request, Order $order)
    {
        // Logic for pending status
        // Allow admin to approve or cancel the order
        if ($request->has('Approve')) {
            $order->update(['status' => 'Approved']);
        } elseif ($request->has('Cancel')) {
            $order->update(['status' => 'Cancelled']);
        }
    }

    private function handleApprovedStatus(Request $request, Order $order)
    {
        // Logic for approved status
        // Allow admin to mark as paid or cancel the order
        if ($request->has('Paid')) {
            $order->update(['status' => 'Paid']);
        } elseif ($request->has('Cancel')) {
            $order->update(['status' => 'Cancelled']);
        }
    }

    private function handlePaidStatus(Request $request, Order $order)
    {
        // Logic for paid status
        // Allow admin to mark as delivered or cancel the order
        if ($request->has('Delivered')) {
            $order->update(['status' => 'Delivered']);
        } elseif ($request->has('Cancel')) {
            $order->update(['status' => 'Cancelled']);
        }
    }

    // private function handleDeliveredStatus(Request $request, Order $order)
    // {
    //     // Logic for delivered status
    //     // Handle any additional actions for delivered status
    //     if ($request->has('Delivered')) {
    //         $order->update(['status' => 'Delivered']);
    //     } elseif ($request->has('Cancel')) {
    //         $order->update(['status' => 'Cancelled']);
    //     }
    // }
}
