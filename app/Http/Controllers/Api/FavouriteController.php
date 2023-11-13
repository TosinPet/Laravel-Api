<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class FavouriteController extends Controller
{
    //
    public function index()
    {
        try{
      
            $user = Auth::user();
            $favoriteProducts = Favourite::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();
            foreach($favoriteProducts as $favoriteProduct)
            {
                $product_id = $favoriteProduct->product_id;
                $product = Product::find($product_id);
                $favoriteProduct['name'] = $product->name;
                $favoriteProduct['slug'] = $product->slug;
                $favoriteProduct['description'] = $product->description;
                $favoriteProduct['quantity'] = $product->quantity;
                $favoriteProduct['price'] = $product->price;
                $favoriteProduct['image'] = $product->image;
            }
            // dd($favoriteProducts);   
            
            return response()->json([
                'data' => [
                    'user' => $user,
                    'favourites' => $favoriteProducts,
                ]
            ], 200);


        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function create(Request $request, $id)
    {
        try {

            $user = Auth::user();

            $favorite = Favourite::where('product_id', '=', $id)
                                    ->where('user_id', '=', $user->id)                            
                                    ->first();
            if($favorite == null){
                $favorites = Favourite::create([
                    'product_id' => $id,
                    'user_id' => $user->id,
    
                ]);
            }              
            
            {
                return response()->json([
                    'message' => 'Product added to favourite successfully',
                    // 'data' => [
                    //     'product_id' => $id,
                    //     'user_id' => $user->id,
                    // ]
                ], 200);
            }

            return response()->json([
                'message' => 'Sorry! An error occurred. Please try again later.'
            ], 500);

        } catch (ValidationException $e)
        {
            return response()->json([
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function destroy($id)
    {
        try {
            $user = Auth::user();    

            $favorite = Favourite::where('product_id', '=', $id)
                                    ->where('user_id', '=', $user->id)                            
                                    ->first();
            $favorite->delete();
            {
                return response()->json([
                    'message' => 'Product deleted from favourites successfully',
                    'data' => [
                        'product_id' => $id,
                        'user_id' => $user->id,
                    ]
                ], 200);
            }
            return response()->json([
                'message' => 'Sorry! An error occurred. Please try again later.'
            ], 500);

        } catch (ValidationException $e)
        {
            return response()->json([
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e)
        {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);

        }
    }
}
