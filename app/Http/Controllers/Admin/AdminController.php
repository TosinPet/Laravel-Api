<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    //
    public function index()
    {
        $admins = User::where('admin', true)->orderBy('created_at', 'DESC')->get();
        // dd($admins);
        return view('admin.users.admins', compact('admins'));
    }

    public function createAdmin(Request $request)
    {
        try {
            $request->validate([
                'full_name' => 'bail|required|string',
                'email' => 'bail|required|email|unique:users,email',
                'phone' => 'bail|required',
                'password' => 'bail|required',
                'status' => 'nullable|integer',
                'suspend' => 'nullable|integer',                
            ]);

            // $pass = random_int(100000, 999999);
            // $password = bcrypt($pass);
            $user = new User();
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);
            $user->active = $request->active ?? 0;
            $user->suspend = $request->suspend ?? 0;
            $user->account = 5;
            $user->admin = 1;
            $user->reference_no = 'ADM'.random_int(1000000000, 9999999999);
            // dd($user);
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

            return redirect()->back()->with('success', "Admin has been created successfully.");
        } catch (ValidationException $th) {
            return back()->with('danger', $th->validator->errors()->first())->withInput();
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage())->withInput();
        }
    }

    public function updateAdmin(Request $request, $user_id)
    {
        try {
            $request->validate([
                'full_name' => 'bail|required|string',
                'email' => 'bail|required|email|unique:users,email,'.$user_id,
                'phone' => 'bail|required|string',
                'password' => 'bail|nullable',
                'status' => 'nullable|integer',
                'suspend' => 'nullable|integer',
            ]);

            $user = User::find($user_id);
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $request->password ? bcrypt($request->password) : $user->password;
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
