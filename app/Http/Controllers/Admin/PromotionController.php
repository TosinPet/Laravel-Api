<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class PromotionController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_promotions'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $promotions = Promotion::orderBy('created_at', 'DESC')->get();
        // dd($banners);
        // dd($banners);   
        return view('admin.cms.promotions.index', compact('promotions'));
    }

    public function createPromotion(Request $request)
    {
        if(!checkPermission('create_promotions'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('post'))
        {
            try
            {
                // dd($request);
                 $this->validate($request, [
                    'name' => 'bail|required|string',
                    'status' => 'nullable|integer',
                    'description' => 'nullable|string',
                    'promotion_image' => 'bail|required',
                    'brands.*.brand_id' => 'bail|required',
                    'brands.*.discount_percentage' => 'bail|required|numeric|min:1',
                ]);

                $slug = Str::slug($request->name);
                $ref = strtoupper(Str::random(20));

                $checkpromotion = Promotion::where('slug', $slug)->first();
                if($checkpromotion)
                {
                    return redirect()->back()->with('danger', 'Sorry! You have already added this Promotion.');
                }

                if($request->hasFile('promotion_image'))
                {
                    $bg_image_path = public_path("uploads/promotions/");

                    $bg_image = $request->file("promotion_image");
                    $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                    if($bg_image->move($bg_image_path, $bg_image_name))
                    {
                        $bg_image_name = $bg_image_name;
                    }
                }else{
                    $bg_image_name = null;
                }

                $promotion = Promotion::create([
                    'name' => $request->name,
                    'slug' => $slug,
                    'description' => $request->description,
                    'status' => $request->status ?? 0,
                    'promotion_image' => $bg_image_name,
                ]);

                $brandsData = $request->input('brands');
                $brandsData = array_values($brandsData);
                // dd($brandsData);

                foreach ($brandsData as $brandData) {
                    // dd($brandData);
                    $brand = Brand::find($brandData['brand_id']);
                    $discountPercentage = $brandData['discount_percentage'];
        
                    // Update brand with the new promotion
                    $brand->update([
                        'discount_percentage' => $discountPercentage,
                        'promotion_id' => $promotion->id, 
                    ]);
                    // dd($brand);
                }

                $this->applyPromotion($promotion);

                return redirect()->back()->with('success', 'Promotion created and applied successfully');

            } catch (ValidationException $e)
            {
                return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
            } catch (\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
        }else{
            try
            {
                $brands = Brand::all();
                return view('admin.cms.promotions.create', compact('brands'));
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function applyPromotion(Promotion $promotion) {
        if (!$promotion->isActive()) {
            return redirect()->back()->with('danger', 'Cannot apply promotion. Promotion is inactive.');
        }

        $brands = Brand::where('promotion_id', $promotion->id)->get();

        foreach ($brands as $brand) {
            $products = $brand->products;
    
            foreach ($products as $product) {
                $discountedPrice = $product->price - ($product->price * ($brand->discount_percentage / 100));
    
                $product->update(['discounted_price' => $discountedPrice]);
            }
        }

        return redirect()->back()->with('success', 'Promotion applied to products.');
    }

    public function deactivatePromotion(Promotion $promotion) {
        if (!$promotion->isActive()) { 

            $brands = Brand::where('promotion_id', $promotion->id)->get();

            foreach ($brands as $brand) {
                // $brandId = $brand->id;
                $brand->promotion_id = null;
                $brand->discount_percentage = null;
                $brand->save();
                
                $products = $brand->products;
    
                foreach ($products as $product) {
                    $product->discounted_price = null;
                    $product->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Promotion deactivated successfully.');
    }



    public function editPromotion(Request $request, $promotion_id)
    {
        if(!checkPermission('edit_promotion'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('patch'))
        {
            try
            {
                 $this->validate($request, [
                    'name' => 'bail|required|string',
                    'status' => 'nullable|integer',
                    'description' => 'nullable|string',
                    'promotion_image' => 'nullable',
                ]);

                $slug = Str::slug($request->name);

                $checkpromotion = Promotion::where('slug', $slug)->where('id', '!=', $promotion_id)->first();;
                if($checkpromotion)
                {
                    return redirect()->back()->with('danger', 'Sorry! You have already added this Promotion.');
                }

                $promotion = Promotion::find($promotion_id);

                if($request->hasFile('promotion_image'))
                {

                    $image_delete_path = public_path("uploads/promotions/" . $promotion->bg_image);
                    if (File::exists($image_delete_path)) {
                        File::delete($image_delete_path);
                    }
                    $bg_image_path = public_path("uploads/promotions/");

                    $bg_image = $request->file("promotion_image");
                    $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                    if($bg_image->move($bg_image_path, $bg_image_name))
                    {
                        $bg_image_name = $bg_image_name;
                    }
                }else{
                    $bg_image_name = $promotion->promotion_image;
                }

                $promotion->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'description' => $request->description,
                    'status' => $request->status ?? 0,
                    'promotion_image' => $bg_image_name,
                ]);

                // if (!$promotion->isActive()) { 
                //     $brandId = $promotion->brand_id;

                //     $promotion->brand_id = null;
                //     $promotion->save();

                //     $products = Product::where('brand_id', $brandId)->get();

                //     // dd($products);

                //     if ($products) {
                //         foreach ($products as $product) {
                //             $product->discounted_price = null;
                //             $product->save();
                //         }
                //     }
                // }

                $this->deactivatePromotion($promotion);

                return redirect()->back()->with('success', 'Promotion updated successfully');

            } catch (ValidationException $e)
            {
                return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
            } catch (\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
        }else{
            try
            {
                $promotion = Promotion::find($promotion_id);
                return view('admin.cms.promotions.edit', compact('promotion'));
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }
}
