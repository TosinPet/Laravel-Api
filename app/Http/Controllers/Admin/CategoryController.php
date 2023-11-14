<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')->get();
        // dd($banners);   
        return view('admin.cms.categories.index', compact('categories'));
    }

    public function createCategory(Request $request)
    {
        if($request->isMethod('post'))
        {
            try
            {
                 $this->validate($request, [
                    'name' => 'bail|required|string',
                    'status' => 'nullable|integer',
                    'category_image' => 'bail|required',
                ]);

                $slug = Str::slug($request->name);
                $ref = strtoupper(Str::random(20));

                $checkcategory = Category::where('slug', $slug)->first();
                if($checkcategory)
                {
                    return redirect()->back()->with('danger', 'Sorry! You have already added this category.');
                }

                // Log::info($seocontent);
                // dd($request->content);

                if($request->hasFile('category_image'))
                {
                    $bg_image_path = public_path("uploads/categories/");

                    $bg_image = $request->file("category_image");
                    $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                    if($bg_image->move($bg_image_path, $bg_image_name))
                    {
                        $bg_image_name = $bg_image_name;
                    }
                }else{
                    $bg_image_name = null;
                }

                $category = Category::create([
                    'name' => $request->name,
                    'slug' => $slug,
                    'last_edited_by' => auth()->user()->id,
                    'status' => $request->status ?? 0,
                    'category_image' => $bg_image_name,
                ]);

                return redirect()->back()->with('success', 'Category created successfully');

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
                return view('admin.cms.categories.create');
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }

    public function editCategory(Request $request, $category_id)
    {
        if($request->isMethod('patch'))
        {
            try
            {
                 $this->validate($request, [
                    'name' => 'bail|required|string',
                    'status' => 'nullable|integer',
                    'category_image' => 'nullable',
                ]);

                $slug = Str::slug($request->name);

                $checkcategory = Category::where('slug', $slug)->where('id', '!=', $category_id)->first();;
                if($checkcategory)
                {
                    return redirect()->back()->with('danger', 'Sorry! You have already added this banner.');
                }

                // Log::info($seocontent);
                // dd($request->content);
                $category = Category::find($category_id);
                // dd($banner);

                if($request->hasFile('category_image'))
                {

                    $image_delete_path = public_path("uploads/categories/" . $category->bg_image);
                    if (File::exists($image_delete_path)) {
                        File::delete($image_delete_path);
                    }
                    $bg_image_path = public_path("uploads/categories/");

                    $bg_image = $request->file("category_image");
                    $bg_image_name = Str::random(16).'.'.$bg_image->extension();

                    if($bg_image->move($bg_image_path, $bg_image_name))
                    {
                        $bg_image_name = $bg_image_name;
                    }
                }else{
                    $bg_image_name = $category->category_image;
                }

                $category->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'last_edited_by' => auth()->user()->id,
                    'status' => $request->status ?? 0,
                    'category_image' => $bg_image_name,
                ]);

                return redirect()->back()->with('success', 'Category updated successfully');

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
                $category = Category::find($category_id);
                return view('admin.cms.categories.edit', compact('category'));
            } catch(\Exception $e)
            {
                // dd($e->getMessage());
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }
}
