<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    //
    public function index()
    {
        try{

            $brands = Brand::where('status', 1)->get();

            return response()->json([
                'data' => [
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

    public function show($id)
    {
        try{

            $products = Product::where('brand_id', '=', $id)->get();
            $brand = Brand::find($id);

            return response()->json([
                'brand' => $brand,
                'products' => $products,
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

}
