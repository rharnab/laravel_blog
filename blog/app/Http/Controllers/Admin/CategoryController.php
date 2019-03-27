<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::latest()->get();
        return view('admin.category.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:categories',
            'image'=>'required|mimes:jpeg,png,jpg',

        ]);

        $image=$request->file('image');
        $slug=str_slug($request->name);
        if(isset($image))
        {
            //image name unique
            $currentDate=Carbon::now()->toDateString();
            $imageName=$slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

             if(!Storage::disk('public')->exists('category'))
             {
                Storage::disk('public')->makeDirectory('category');
             }
             $category=Image::make($image)->resize(1600, 479)->stream();
             Storage::disk('public')->put('category/'.$imageName, $category);
             //slider Name 
             if(!Storage::disk('public')->exists('category/slider'))
             {
                Storage::disk('public')->makeDirectory('category/slider');
             }
             $slider=Image::make($image)->resize(500,333)->stream();
             Storage::disk('public')->put('Category/slider/'.$imageName, $slider);

             

        }
        else{
            $imageName='default.png';
        }
         

         $category=new Category;
         $category->name=$request->name;
         $category->slug=$slug;
         $category->image=$imageName;
         $category->save();

         Toastr::success('success','Category creaated successfully');
         return redirect('admin/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=Category::find($id);
        return view('admin.category.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'image'=>'mimes:jpg,png,jpeg',

        ]);

         $image=$request->file('image');
         $slug=str_slug($request->name);
         $category=Category::find($id);
         if(isset($image))
         {
            $currentDate=Carbon::now()->toDateString();
            $imageName=$slug.'-'.$currentDate.'-'.uniqid().'-'.'.'.$image->getClientOriginalExtension();


            if(!Storage::disk('public')->exists('category'))
             {
                Storage::disk('public')->makeDirectory('category');
             }

             if(Storage::disk('public')->exists('category/'.$category->image))
             {
                Storage::disk('public')->delete('category/'.$category->image);
             }

             $categoryimage=Image::make($image)->resize(1600,479)->stream();
             Storage::disk('public')->put('category/'.$imageName, $categoryimage);

             if(!Storage::disk('public')->exists('category/slider'))
             {
                Storage::disk('public')->makeDirectory('category/slider');
             }
             if(Storage::disk('public')->exists('category/slider/'.$category->image))
             {
                Storage::disk('public')->delete('category/slider/'.$category->image);

             }

             $categoryimageSlider=Image::make($image)->resize(500,333)->stream();
             Storage::disk('public')->put('category/slider/'.$imageName, $categoryimageSlider);

         }
         else{
            $imageName= $category->image;
         }
         $category->Name=$request->name;
         $category->slug=$slug;
         $category->image=$imageName;
         $category->save();
         Toastr::success('success','Category Updated successfully');
         return redirect('admin/category');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::find($id);
        if(Storage::disk('public')->exists('category/'.$category->image))
        {
            Storage::disk('public')->delete('category/'.$category->image);
        }
        if(Storage::disk('public')->exists('category/slider/'.$category->image))
        {
            storage::disk('public')->delete('category/slider/'.$category->image);
        }
        $category->delete();
        Toastr::success('Category successfully deletee', 'success');
        return redirect()->back();
    }
}
