<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        try{
      
            $user = Auth::user();
            $purchasehistory = Purchase::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();
            return response()->json([
                'data' => [
                    'user' => $user,
                    'purchasehistory' => $purchasehistory,
                ]
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }
}