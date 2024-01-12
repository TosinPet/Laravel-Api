<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Customer;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_purchases'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $purchases = Purchase::orderBy('created_at', 'DESC')->get();
        foreach($purchases as $purchase)
        {
            $user_id = $purchase->user_id;
            $user = User::find($user_id);
            $purchase["full_name"] = $user->full_name;
        }
        return view('admin.purchase.index', compact('purchases'));
    }
    
    public function createPurchase(Request $request)
    {
        if(!checkPermission('create_purchase'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('post'))
        {
            try
                {
                    // dd($request);
                    $this->validate($request, [
                        'customer_name' => 'bail|required',
                        'order_date' => 'bail|required|string',
                        'order_number' => 'bail|required|string',
                        'total_amount' => 'bail|required|integer',
                    ]);
                    // dd($request);
                    $user = User::find($request->customer_name);

                    if (!$user) {
                        // Handle the case where the user is not found, for example, redirect back with an error message.
                        return redirect()->back()->with('danger', 'Invalid customer selected.');
                    }

                    $purchase = Purchase::create([
                        'user_id' => $request->customer_name,
                        'phone' => $user->phone_number,
                        'order_number' => $request->order_number,
                        'order_date' => $request->order_date,
                        'total_amount' => $request->total_amount,
                    ]);
                    // dd($purchase);
                    return redirect()->back()->with('success', 'Purchase created successfully');


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
                    return view('admin.purchase.create', compact('customers'));
                } catch(\Exception $e)
                {
                    // dd($e->getMessage());
                    return redirect()->back()->with('danger', $e->getMessage());
                }
        }
    }
}
