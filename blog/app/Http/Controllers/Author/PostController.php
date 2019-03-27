<?php

namespace App\Http\Controllers\Author;

use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
Use Auth;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use App\Notifications\NewAuthorPost;
use App\User;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Auth::user()->posts()->latest()->get();
        return view('author.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags=Tag::latest()->get();
        $categories=Category::latest()->get();
        return view('author.post.create', compact(['tags', 'categories']));
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
            $today=Carbon::now()->toDateString();
            $imageName='slug'.'-'.$today.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if(!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }
            $postImage=Image::make($image)->resize(1600,1066)->stream();
            Storage::disk('public')->put('post/'.$imageName, $postImage);

        }
        else
        {
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
        $post->is_approved=false;

        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        $users=User::where('role_id', '1')->get();
        Notification::send($users, new NewAuthorPost($post));

        Toastr::success('Post added successfull');
        return redirect('author/post');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if($post->user_id !=Auth::id())
        {
            Toastr::error('your are not authorized for this');
            return redirect()->back();
        }
        else{
            return view('author.post.show', compact('post'));
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if($post->user_id !=Auth::id())
        {
            Toastr::error('your are not authorized for this');
            return redirect()->back();
        }

        $categories=Category::all();
        $tags=Tag::all();
        return view('author.post.edit', compact(['post', 'categories', 'tags']));
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
        if($post->user_id !=Auth::id())
        {
            Toastr::error('your are not authorized for this');
            return redirect()->back();
        }

        $this->validate($request, [
                'title'=>'required',
                'image'=>'image',
                'categories'=>'required',
                'tags'=>'required',
                'body'=>'required',
        ]);

        $image=$request->file('image');
        if($image)
        {
            $today=Carbon::now()->toDateString();
            $imageName='slug'.'-'.$today.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if(Storage::disk('public')->exists('post/'.$post->image))
            {
                Storage::disk('public')->delete('post/'.$post->image);
            }

            if(!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }
            

            $postImage=Image::make($image)->resize(1600,1066)->stream();
            Storage::disk('public')->put('post/'.$imageName, $postImage);


        }
        else{
            $imageName=$post->image;
        }

        $post->user_id=Auth::user()->id;
        $post->title=$request->title;
        $post->slug=str_slug($request->title);
        $post->image=$imageName;
        $post->body=$request->body;
        if($request->status)
        {
            $post->status=true;
        }
        else{
            $post->status=false;
        }
        $post->save();
        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('Post updated successfull');
        return redirect('author/post');
    }

    /**
     * Remove the specified resourifce from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->user_id !=Auth::id())
        {
            Toastr::error('your are not authorized for this');
            return redirect()->back();
        }
        
        $post->categories()->detach($post->categories);
        $post->tags()->detach($post->tags);
        if(Storage::disk('public')->exists('post/'.$post->image))
        {
            Storage::disk('public')->delete('post/'.$post->image);
        }
        $post->delete();
        Toastr::success('post delete success');
        return redirect('author/post');
    }
}
