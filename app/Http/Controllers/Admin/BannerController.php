<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Banner;
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
                 $this->validate($request, [
                    'name' => 'bail|required|string',
                    'status' => 'nullable|integer',
                    'description' => 'nullable|string',
                    'banner_image' => 'bail|required',
                ]);

                $slug = Str::slug($request->name);
                $ref = strtoupper(Str::random(20));

                $checkbanner = Banner::where('slug', $slug)->first();
                if($checkbanner)
                {
                    return redirect()->back()->with('danger', 'Sorry! You have already added this banner.');
                }

                // Log::info($seocontent);
                // dd($request->content);

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
                ]);

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
                return view('admin.cms.banners.create');
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
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
