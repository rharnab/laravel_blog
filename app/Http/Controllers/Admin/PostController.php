<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
use Auth;
use App\Notifications\AuthorPostApprove;
use App\Notifications\NewPostNotify;
use App\Sibscribe;
use Illuminate\Support\Facades\Notification;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Post::latest()->get();
        return view('admin.post.index')->with('posts', $posts);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        $tags=Tag::all();
        return view('admin.post.create')->with('categories', $categories)->with('tags', $tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'title'=>'required',
                'image'=>'required|image',
                'categories'=>'required',
                'tags'=>'required',
                'body'=>'required',
        ]);

        $title=$request->title;
        $slug=str_slug($title);
        $image=$request->file('image');
        if($image)
        {
            $date=Carbon::now()->toDateString();
            $imageName=$slug.'-'.$date.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('post'))
             {
                Storage::disk('public')->makeDirectory('post');
             }
            $postImage=Image::make($image)->resize(1600,1066)->stream();
            Storage::disk('public')->put('post/'.$imageName, $postImage);
            //$image->move('storage/post', $imageName, $postImage);

        }
        else{
            $imageName='default.png';
        }

        $post=new Post;
        $post->user_id=Auth::id();
        $post->title=$request->title;
        $post->slug=$slug;
        $post->image=$imageName;
        $post->body=$request->body;
        if(isset($request->status))
        {
            $post->status=true;
        }
        else{
            $post->status=false;
        }
        $post->is_approved=true;

        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        $subscribers=Sibscribe::all();
        foreach($subscribers as $subscriber)
        {
             Notification::route('mail', $subscriber->email)->Notify(new NewPostNotify($post));


        }
       

        Toastr::success('Post added successfull');
        return redirect('admin/post');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
         $categories=Category::all();
         $tags=Tag::all();
        return view('admin.post.edit')->with('categories', $categories)->with('tags', $tags)->with('post', $post);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
         $this->validate($request, [
                'title'=>'required',
                'image'=>'image',
                'categories'=>'required',
                'tags'=>'required',
                'body'=>'required',
        ]);

        $image=$request->file('image');
        $title=$request->title;
        $slug=str_slug($title);
        if($image)
        {

            $date=Carbon::now()->toDateString();
            $imageName=$slug.'-'.$date.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if(!Storage::disk('public')->exists('post/', $post->image))
            {
                Storage::disk('public')->delete('post/',$post->image);
            }

            $postImage=Image::make($image)->resize(1600, 1066)->stream();
            Storage::disk('public')->put('public/', $imageName, $postImage);


        }
         else{
            $imageName=$post->image;
        }

        $post->user_id=Auth::id();
        $post->title=$request->title;
        $post->slug=$slug;
        $post->image=$imageName;
        $post->body=$request->body;
        if(isset($request->status))
        {
            $post->status=true;
        }
        else{
            $post->status=false;
        }
        $post->is_approved=true;

        $post->save();
        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

      Toastr::success('Post edit successfull');
        return redirect('admin/post');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(Storage::disk('public')->exists('post/'.$post->image))
        {
            Storage::disk('public')->delete('post/'.$post->image);
        }
        $post->categories->detach();
        $post->tags->detach();
        $post->delete();
        Toastr::success('post delete success');
        return redirect('admin/post');
    }

    public function pending()
    {
        $posts=Post::where('is_approved', false)->get();
        return view('admin.post.pending', compact('posts'));
    }

    public function approval($id)
    {
        $post=Post::find($id);
        if($post->is_approved==false)
        {
            $post->is_approved=true;
            $post->user->Notify(new AuthorPostApprove($post));

           $subscribers=Sibscribe::all();
            foreach($subscribers as $subscriber)
            {
                 Notification::route('mail', $subscriber->email)->Notify(new NewPostNotify($post));


            }
       
        }
        $post->save();
        Toastr::success('post Approved success');
        return redirect('admin/post');

    }
}
