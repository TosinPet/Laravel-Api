<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Helpers\TraveldenApp;
use Illuminate\Support\Str;
use Image;
use File;

use App\Models\ErrorLog;
use App\Models\User;
use App\Models\FlightBooking;
use App\Models\VisaApplication;
use App\Models\HolidayApplication;

class UserService 
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function updateUser($data)
    {
        $user = $this->user->where('id', $data['user_id'])->first();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->image = $data['image'];

        $user->save();

        return [
            'message' => 'Profile updated successfully',
            'error' => false,
            'data' => $user
        ];
    }


    public function getUserProfile($user_id)
    {
        $user = $this->user->where('id', $user_id)->first();

        return [
            'message' => 'Profile fetched successfully',
            'error' => false,
            'data' => $user,
            // 'logo_path' => 'uploads/affiliates/'
        ];
    }


    public function changePassword($data)
    {
        $user = auth('sanctum')->user();

        $curpassword = $data['current_password'];
        $userpass = $user->password;

        if(!Hash::check($curpassword, $userpass))
        {
            return [
                'message' => 'Incorrect current password provided',
                'error' => true,
            ];
        }

        if($data['new_password'] == $data['current_password'])
        {
            return [
                'message' => 'You cannot use current password as new password',
                'error' => true,
            ];
            
        }

        $hasher = app()->make('hash');
        $user->update([
            'password' => $hasher->make($data['new_password']),
        ]);

        return [
            'message' => 'Password updated successfully',
            'error' => false,
            'data' => $user
        ];
    }

}