<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use App\Models\Banner;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    //
    public function index()
    {
        try{

            $promotions = Promotion::where('status', 1)->get();

            return response()->json([
                'data' => [
                    'promotions' => $promotions,
                ]
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function show($id)
    {
        try{

            $brands = Brand::where('promotion_id', '=', $id)->get();
            $promotion = Promotion::find($id);

            return response()->json([
                'data' => [
                    'promotion' => $promotion,
                    'brands' => $brands,
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
