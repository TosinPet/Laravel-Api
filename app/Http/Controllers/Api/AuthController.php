<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\PasswordReset;
use Illuminate\Http\Request;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        try{

            $validated = $request->validate([
                'phone_number' => 'required',
                'password' => 'required|min:6'
            ]);
            // dd($validated);
    
            if (! Auth::attempt($validated)){
                return response()->json([
                    'message' => 'Login information is invalid',
                ], 401);
            }
    
            $user = User::where('phone_number', $validated['phone_number'])->first();
            $user = Auth::user();
            $customer = Customer::where('user_id', '=', $user->id)->first();
            $customer_account = CustomerAccount::where("customer_id", '=', $customer->id)->first();

            return response()->json([
                'access_token' => $user->createToken('api_token')->plainTextToken,
                'token_type' => 'Bearer',
                'message' => 'You have been logged in',
                'customer' => $customer,    
                'customer_account' => $customer_account,
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function register(Request $request)
    {
        try{

            $validated = $request->validate([
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|max:225|email|unique:users,email',
                'password' => 'required|confirmed|min:6',
                // 'image' => 'nullable',
            ]);
    
            $validated['password'] = Hash::make($validated['password']);
    
            $user = User::create($validated);
    
            return response()->json([
                'data' => $user,
                'access_token' => $user->createToken('api_token')->plainTextToken,
                'token_type' => 'Bearer',
            ], 201);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function resetPassword(Request $request)
    {
        try{
            $this->validate($request, [
                'phone_number' => 'bail|required',
            ]);

            $checkuser = User::where('phone_number', $request->phone_number)->where('suspend', 0)->first();
            if($checkuser)
            {
                $token = random_int(1000000, 9999999);
                $user = $checkuser;
                $checktoken = PasswordResetToken::where('phone_number', $user->phone_number)->first();
                if($checktoken)
                {
                    $checktoken->phone_number = $user->phone_number;
                    $checktoken->token = $token;
                    $checktoken->save();
                }else{
                    $checktoken = PasswordResetToken::create([
                        'phone_number' => $user->phone_number,
                        'token' => $token,
                    ]);
                }
                try{
                    return response()->json([
                        'token' => $token,
                    ], 200);
                    //Uncomment the mail line and comment the return response
                    // Mail::to($user->email)->queue(new PasswordReset($user, $token));
                } catch (\Exception $e)
                {
                    Log::info($e->getMessage());
                }
                return response()->json([
                    'message' => 'A message has been sent to your email address. Please check your email to reset your password.',
                ], 200);
            }else{
                return response()->json([
                    'message' => 'Sorry! The provided email cannot be found in our system.',
                ], 422);
            }
        } catch (ValidationException $e)
        {
            return response()->json([
                "message" => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e)
        {
            return response()->json([
                "message" => $e->getMessage(),
				"trace" => $e->getTraceAsString()
            ], 500);

        }
    }

    public function activateResetPassword(Request $request, $token)
    {
        try
        {
            $this->validate($request, [
                'phone_number' => 'bail|required',
                'new_password' => 'bail|required|min:6',
                'confirm_password' => 'bail|required',
            ]);

            if($request->new_password != $request->confirm_password)
            {
                return response()->json([
                    'message' => 'Sorry! The new password does not match the confirm password',
                ], 422);
            }

            $checktoken = PasswordResetToken::where('phone_number', $request->phone_number)
            ->where('token', $token)->first();

            if($checktoken)
            {
                $hasher = app()->make('hash');
                $date = Carbon::parse($checktoken->updated_at);
                $addonehour = $date->addHour(1);
                if($addonehour > Carbon::now())
                {
                    $user = User::where('phone_number', $request->phone_number)->first();
                    $user->password = bcrypt($request->new_password);
                    $user->save();

                    $checktoken->delete();

                    // $user->notify(new ConfirmResetPassword($user));

                    return response()->json([
                        'message' => 'Your password has been updated successfully.',
                    ], 200);

                }else{
                    $checktoken->delete();
                    return response()->json([
                        'message' => 'Invalid token',
                    ], 422);
                }
            }else{
                return response()->json([
                    'message' => 'Invalid token',
                ], 422);
            }
        } catch (ValidationException $e)
        {
            return response()->json([
                "message" => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e)
        {
            return response()->json([
                "message" => $e->getMessage(),
                "trace" => $e->getTraceAsString()
            ], 500);

        }
    }

    public function logout(Request $request)
    {
        // Auth::user()->tokens()->delete();
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'You have been logged out',
        ], 201);
    }
}
