<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportSku;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

class SKUController extends Controller
{
    //
    public function index()
    {
        if(!checkPermission('view_sku'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        $skus = Product::orderBy('created_at', 'DESC')->get();
        // dd($skus);   
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.sku.index', compact('skus', 'categories', 'brands'));
    }

    public function createSku(Request $request)
    {
        if(!checkPermission('create_sku'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        if($request->isMethod('post'))
        {
            try
            {
                 $this->validate($request, [
                    'name' => 'bail|required|string',
                    'status' => 'nullable|integer',
                    'description' => 'bail|nullable|string',
                    'short_description' => 'bail|nullable|string',
                    'category' => 'bail|required|integer',
                    'brand' => 'bail|required|integer',
                    'cases' => 'bail|required|string',
                    'reference_number' => 'bail|required|string',
                    'quantity' => 'bail|required|string',
                    'price' => 'bail|required|string',
                    'image' => 'bail|required',
                    'status' => 'nullable|integer',
                ]);

                $slug = Str::slug($request->name);
                $ref = strtoupper(Str::random(20));

                $checkproduct = Product::where('slug', $slug)->first();
                if($checkproduct)
                {
                    return redirect()->back()->with('danger', 'Sorry! You have already added this Product.');
                }

                // Log::info($seocontent);
                // dd($request->content);

                if($request->hasFile('image'))
                {
                    $bg_image_path = public_path("uploads/skus/");

                    $bg_image = $request->file("image");
                    $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                    if($bg_image->move($bg_image_path, $bg_image_name))
                    {
                        $bg_image_name = $bg_image_name;
                    }
                }else{
                    $bg_image_name = null;
                }

                $sku = Product::create([
                    'name' => $request->name,
                    'slug' => $slug,
                    'description' => $request->description,
                    'short_description' => $request->short_description,
                    'category_id' => $request->category,
                    'brand_id' => $request->brand,
                    'cases' => $request->cases,
                    'reference_number' => $request->reference_number,
                    'quantity' => $request->quantity,
                    'price' => $request->price,
                    'image' => $bg_image_name,
                ]);

                return redirect()->back()->with('success', 'Product created successfully');

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
                $categories = Category::all();
                $brands = Brand::all();
                // dd($categories);
                return view('admin.sku.create', compact('categories', 'brands'));
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function editSku(Request $request, $product_id)
    {
        if(!checkPermission('edit_sku'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try
        {
            // dd($request);
            $this->validate($request, [
                'name' => 'bail|required|string',
                'status' => 'nullable|integer',
                'description' => 'bail|nullable|string',
                'category' => 'bail|required|integer',
                'brand' => 'bail|required|integer',
                'cases' => 'bail|required|string',
                'reference_number' => 'bail|required|string',
                'quantity' => 'bail|required|string',
                'price' => 'bail|required|string',
                'image' => 'nullable',
            ]);

            $slug = Str::slug($request->name);

            $checksku = Product::where('slug', $slug)->where('id', '!=', $product_id)->first();;
            if($checksku)
            {
                return redirect()->back()->with('danger', 'Sorry! You have already added this Product.');
            }

            // Log::info($seocontent);
            // dd($request->content);
            $sku = Product::find($product_id);
            // dd($banner);

            if($request->hasFile('image'))
            {

                $image_delete_path = public_path("uploads/skus/" . $sku->bg_image);
                if (File::exists($image_delete_path)) {
                    File::delete($image_delete_path);
                }
                $bg_image_path = public_path("uploads/skus/");

                $bg_image = $request->file("image");
                $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                if($bg_image->move($bg_image_path, $bg_image_name))
                {
                    $bg_image_name = $bg_image_name;
                }
            }else{
                $bg_image_name = $sku->image;
            }

            $sku->update([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'category_id' => $request->category,
                'brand_id' => $request->brand,
                'cases' => $request->cases,
                'reference_number' => $request->reference_number,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'status' => $request->status ?? 0,
                'image' => $bg_image_name,
            ]);

            return redirect()->back()->with('success', 'Product updated successfully');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }

    public function exportSku(Request $request)
    {
        if(!checkPermission('export_sku'))
        {
            return redirect()->back()->with('danger', 'Access Forbidden');
        }
        try{
            return Excel::download(new ExportSku, 'products.xlsx');

        } catch (ValidationException $e)
        {
            return redirect()->back()->with('danger', $e->validator->errors()->first());
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());

        }
        
    }
}
