<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    //
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function updateProfile(Request $request)
    {
        try{
            $this->validate($request, [
                'first_name' => 'bail|required|string',
                'last_name' => 'bail|required|string',
                'email' => 'bail|required|email',
                'image' => 'nullable',
            ]);
    
            $user_id = auth('sanctum')->user()->id;
            $data = $request->all();
            if($request->hasFile('image'))
            {
    
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move('user/profile/',$filename);
                $image = $filename;
            }
            $data['user_id'] = $user_id;
    
            $user = $this->userService->updateUser($data);
    
            return response()->json([
                'data' => [
                    'user' => $user,
                ]
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function fetchProfile()
    {
        try{

            $user_id = auth('sanctum')->user()->id;
            $user = $this->userService->getUserProfile($user_id);
        
            return response()->json([
                'data' => [
                    'user' => $user,
                ]
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function changePassword(Request $request)
    {
        // try{
            $this->validate($request, [
                'current_password' => 'bail|required',
                'new_password' => 'bail|required|min:6',
    
            ]);
    
            $data = $request->all();
            // dd($data);
    
            $user = $this->userService->changePassword($data);
    
            return response()->json([
                    'message' => "Password updated successfully",
            ], 200);

        // } catch (\Exception $e)
        // {
        //     return response()->json([
        //         'message' => $e->getMessage()
        //     ], 500);

        // }
    }

}
