<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index()
    {
        try{

            $categories = Category::where('status', 1)->get();

            return response()->json([
                'data' => [
                    'categories' => $categories,
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

            $products = Product::where('category_id', '=', $id)->get();
            $category = Category::find($id);

            return response()->json([
                'data' => [
                    'category' => $category,
                    'products' => $products,
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
