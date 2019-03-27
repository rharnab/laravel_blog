<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use Session;
class PostController extends Controller
{
	public function index()
	{
		$posts=Post::latest()->Approved()->Published()->simplepaginate(6);
		return view('posts', compact('posts'));
	}
    public function post_details($slug)
    {
    	$post=Post::where('slug', $slug)->Approved()->Published()->first();
    	$blogkey='blog'.$post->id;
    	if(!Session::has($blogkey))
    	{
    		$post->increment('view_count');
    		Session::put($blogkey,1);
    	}

    	$randoms=Post::Approved()->Published()->take(3)->inRandomorder()->get();
    	return view('post-details', compact(['post', 'randoms']));
    }

    public function postByCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();

        $posts=$category->posts()->Approved()->Published()->get();
        return view('category', compact(['category', 'posts']));
    }

    public function postByTag($slug)
    {
        $tag=Tag::where('slug', $slug)->first();
        $posts=$tag->posts()->Approved()->Published()->get();
        return view('tags', compact(['tag', 'posts']));
    }
}
