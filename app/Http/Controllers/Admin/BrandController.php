<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    //
    public function index()
    {
        $brands = Brand::orderBy('created_at', 'DESC')->get();
        // dd($banners);   
        return view('admin.cms.brands.index', compact('brands'));
    }

    public function createBrand(Request $request)
    {
        if($request->isMethod('post'))
        {
            try
            {
                 $this->validate($request, [
                    'name' => 'bail|required|string',
                    'status' => 'nullable|integer',
                    'description' => 'nullable|string',
                    'brand_image' => 'bail|required',
                ]);

                $slug = Str::slug($request->name);
                $ref = strtoupper(Str::random(20));

                $checkbrand = Brand::where('slug', $slug)->first();
                if($checkbrand)
                {
                    return redirect()->back()->with('danger', 'Sorry! You have already added this brand.');
                }

                // Log::info($seocontent);
                // dd($request->content);

                if($request->hasFile('brand_image'))
                {
                    $bg_image_path = public_path("uploads/brands/");

                    $bg_image = $request->file("brand_image");
                    $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                    if($bg_image->move($bg_image_path, $bg_image_name))
                    {
                        $bg_image_name = $bg_image_name;
                    }
                }else{
                    $bg_image_name = null;
                }

                $brand = Brand::create([
                    'name' => $request->name,
                    'slug' => $slug,
                    'description' => $request->description,
                    'last_edited_by' => auth()->user()->id,
                    'status' => $request->status ?? 0,
                    'brand_image' => $bg_image_name,
                ]);

                return redirect()->back()->with('success', 'Brand created successfully');

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
                return view('admin.cms.brands.create');
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function editBrand(Request $request, $brand_id)
    {
        if($request->isMethod('patch'))
        {
            try
            {
                 $this->validate($request, [
                    'name' => 'bail|required|string',
                    'status' => 'nullable|integer',
                    'description' => 'nullable|string',
                    'brand_image' => 'nullable',
                ]);

                $slug = Str::slug($request->name);

                $checkbrand = Brand::where('slug', $slug)->where('id', '!=', $brand_id)->first();;
                if($checkbrand)
                {
                    return redirect()->back()->with('danger', 'Sorry! You have already added this banner.');
                }

                // Log::info($seocontent);
                // dd($request->content);
                $brand = Brand::find($brand_id);
                // dd($banner);

                if($request->hasFile('brand_image'))
                {

                    $image_delete_path = public_path("uploads/banners/" . $brand->bg_image);
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
                    $bg_image_name = $brand->brand_image;
                }

                $brand->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'description' => $request->description,
                    'last_edited_by' => auth()->user()->id,
                    'status' => $request->status ?? 0,
                    'brand_image' => $bg_image_name,
                ]);

                return redirect()->back()->with('success', 'Brand updated successfully');

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
                $brand = Brand::find($brand_id);
                return view('admin.cms.brands.edit', compact('brand'));
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }
}
