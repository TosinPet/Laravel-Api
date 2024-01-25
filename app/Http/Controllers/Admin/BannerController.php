<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class BannerController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_banner'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $banners = Banner::orderBy('created_at', 'DESC')->get();
        // dd($banners);   
        return view('admin.cms.banners.index', compact('banners'));
    }

    public function createBanner(Request $request)
    {
        if(!checkPermission('create_banner'))
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
                    'banner_image' => 'bail|required',
                    'percentage_discount' => 'numeric',
                    'brand' => 'integer',
                ]);

                $slug = Str::slug($request->name);
                $ref = strtoupper(Str::random(20));

                $checkbanner = Banner::where('slug', $slug)->first();
                if($checkbanner)
                {
                    return redirect()->back()->with('danger', 'Sorry! You have already added this banner.');
                }

                if($request->hasFile('banner_image'))
                {
                    $bg_image_path = public_path("uploads/banners/");

                    $bg_image = $request->file("banner_image");
                    $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                    if($bg_image->move($bg_image_path, $bg_image_name))
                    {
                        $bg_image_name = $bg_image_name;
                    }
                }else{
                    $bg_image_name = null;
                }

                $banner = Banner::create([
                    'name' => $request->name,
                    'slug' => $slug,
                    'description' => $request->description,
                    'last_edited_by' => auth()->user()->id,
                    'status' => $request->status ?? 0,
                    'banner_image' => $bg_image_name,
                    'brand_id' => $request->brand,
                    'percentage_discount' => $request->percentage_discount,
                ]);

                $this->applyPromotion($banner);

                return redirect()->back()->with('success', 'Banner created successfully');

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
                return view('admin.cms.banners.create', compact('brands'));
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function applyPromotion(Banner $banner)
    {
        $brand = $banner->brand;

        if (!$brand) {
            return redirect()->view('admin.cms.banners.create')->with('danger', 'Brand not found.');
        }
    
        $products = $brand->products;

        foreach ($products as $product) {
            if ($banner->isActive()) {
                $product->discounted_price = $product->price - ($product->price * ($banner->percentage_discount / 100));
            } else {
                $product->discounted_price = null;
            }

            $product->save();
        }

        if (!$banner->isActive()) { 
            $banner->brand_id = null;
            $banner->save();
        }

        return redirect()->back()->with('success', 'Banner Promotion applied successfully to products.');
    }

    public function editBanner(Request $request, $banner_id)
    {
        if(!checkPermission('edit_banner'))
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
                    'banner_image' => 'nullable',
                ]);

                $slug = Str::slug($request->name);

                $checkbanner = Banner::where('slug', $slug)->where('id', '!=', $banner_id)->first();;
                if($checkbanner)
                {
                    return redirect()->back()->with('danger', 'Sorry! You have already added this banner.');
                }

                // Log::info($seocontent);
                // dd($request->content);
                $banner = Banner::find($banner_id);
                // dd($banner);

                if($request->hasFile('banner_image'))
                {

                    $image_delete_path = public_path("uploads/banners/" . $banner->bg_image);
                    if (File::exists($image_delete_path)) {
                        File::delete($image_delete_path);
                    }
                    $bg_image_path = public_path("uploads/banners/");

                    $bg_image = $request->file("banner_image");
                    $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                    if($bg_image->move($bg_image_path, $bg_image_name))
                    {
                        $bg_image_name = $bg_image_name;
                    }
                }else{
                    $bg_image_name = $banner->banner_image;
                }

                $banner->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'description' => $request->description,
                    'last_edited_by' => auth()->user()->id,
                    'status' => $request->status ?? 0,
                    'banner_image' => $bg_image_name,
                ]);

                if (!$banner->isActive()) { 
                    $brandId = $banner->brand_id;

                    $banner->brand_id = null;
                    $banner->save();

                    $products = Product::where('brand_id', $brandId)->get();

                    // dd($products);

                    if ($products) {
                        foreach ($products as $product) {
                            $product->discounted_price = null;
                            $product->save();
                        }
                    }
                }

                return redirect()->back()->with('success', 'Banner updated successfully');

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
                $banner = Banner::find($banner_id);
                return view('admin.cms.banners.edit', compact('banner'));
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }
}
