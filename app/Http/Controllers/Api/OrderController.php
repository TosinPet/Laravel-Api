<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    //
    public function index()
    {
        try{
            
            $user = Auth::user();
            $orders = Order::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();
            // $orders = $order;
            // $orders = QueryBuilder::for(Order::class)
            //                         ->allowedFilters(['status'])->get();
            return response()->json([
                'data' => [
                    'user' => $user,
                    'orders' => $orders,
                ]
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function create(Request $request)
    {
        try{

            $validated = $request->validate([
                'shipping_address' => 'bail|required|string',
                'phone' => 'bail|required|string',
                'subtotal' => 'bail|required|string',
                'total_amount' => 'bail|required|string',
             ]);
    
            $user = Auth::user();
    
            $order = Order::create([
                'email' => $user->email,
                'phone' => $user->phone,
                'shipping_address' => $validated['shipping_address'],
                'phone' => $validated['phone'],
                'subtotal' => $validated['subtotal'],
                'total_amount' => $validated['total_amount'],
                'order_date' => Carbon::now()->toDateTimeString(),
                'order_number' => 'KIR'.random_int(1000000000, 9999999999),
                'user_id' => $user->id,
            ]);
    
            $products = $request['products'];
            foreach($products as $product)
            {
                $order_item = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'unit_price' => $product['unit_price'],
                    'total_price' => $product['total_price'],
                ]);
            }
    
            return response()->json([
                'message' => 'Order created successfully'
            ], 200);

        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }

    }

    public function show($order_id)
    {
        try{

            $user = Auth::user();
            $order = Order::where('id', $order_id)
                            ->where('user_id', '=', $user->id)->first();
            
            $order_items = OrderItem::where('order_id','=', $order->id)->get();
            foreach($order_items as $order_item)
            {
                $product_id = $order_item->product_id;
                $product = Product::find($product_id);
                $order_item['product_name'] = $product->name;
                $order_item['product_description'] = $product->description;
                $order_item['product_quantity'] = $product->quantity;
                $order_item['product_image'] = $product->image;
                $order_item['product_price'] = $product->price;
            }
            $order = Order::where('user_id', '=', Auth::user()->id)->where('id', $order_id)->first();
            if($order)
            {
                return response()->json([
                    'data' => [
                        'order' => $order,
                        'orderItems' => $order_items,
                    ]
                ], 200);
            }

        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }
}
