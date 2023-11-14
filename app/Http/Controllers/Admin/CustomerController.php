<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $customers = User::where('admin', false)->get();
        // $customers = Customer::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.customer', compact('customers'));
    }

    public function createCustomer(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'bail|required|string',
                'last_name' => 'bail|required|string',
                'email' => 'bail|required|email|unique:users,email',
                'phone' => 'bail|required',
                'status' => 'nullable|integer',
                'suspend' => 'nullable|integer',                
            ]);

            $pass = random_int(100000, 999999);
            $password = bcrypt($pass);
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $password;
            $user->active = $request->active ?? 0;
            $user->suspend = $request->suspend ?? 0;
            $user->account = 1;
            $user->admin = 0;
            $user->reference_no = 'CUS'.random_int(1000000000, 9999999999);
            $user->save();

            // if($request->is_approved && $request->is_approved == 1 && $affiliate->is_approved == 0)
            // {
                // Log::info('affiliate');
                // try{
                //     Mail::to($user)->queue(new AffiliateWelcomeEmail($affiliate, $pass));
                // } catch (\Exception $e)
                // {
                //     Log::info($e->getMessage());
        
                // }
            // }

            return redirect()->back()->with('success', "Customer has been created successfully.");
        } catch (ValidationException $th) {
            return back()->with('danger', $th->validator->errors()->first())->withInput();
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage())->withInput();
        }
    }

    public function updateCustomer(Request $request, $user_id)
    {   
        try {
            $request->validate([
                'first_name' => 'bail|required|string',
                'last_name' => 'bail|required|string',
                'email' => 'bail|required|email|unique:users,email,'.$user_id,
                'phone' => 'bail|required|string',
                'status' => 'nullable|integer',
                'suspend' => 'nullable|integer',
            ]);

            $user = User::find($user_id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->active = $request->active ?? 0;
            $user->suspend = $request->suspend ?? 0;
            $user->save();


            return redirect()->back()->with('success', "Customer has been edited successfully.");
        } catch (ValidationException $th) {
            return back()->with('danger', $th->validator->errors()->first());
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage());
        }
    }
}

