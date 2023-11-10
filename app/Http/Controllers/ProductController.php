<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    //
    public function index()
    {
        try{

            $product = Product::where('status', 1)->get();
            $products = $product;
            $products = QueryBuilder::for(Product::class)
                ->allowedFilters(['category_id', 'starts_before'])
                // ->allowedFilters([
                //     AllowedFilter::scope('starts_before'),
                // ])
            ->paginate(10);

            return response()->json([
                'data' => [
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

    public function show($product_id)
    {
        try{

            $product = Product::where('id', $product_id)->where('status', 1)->first();

            return response()->json([
                'data' => [
                    'product' => $product,
                ]
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function search($name)
    {
        return Product::where('name', 'like', '%'.$name.'%')->get();
    }
}
