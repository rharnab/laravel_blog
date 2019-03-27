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
		$posts=Post::approved()->published()->latest()->simplepaginate(6);
		return view('posts', compact('posts'));
	}
    public function post_details($slug)
    {
    	$post=Post::where('slug', $slug)->first();
    	$blogkey='blog'.$post->id;
    	if(!Session::has($blogkey))
    	{
    		$post->increment('view_count');
    		Session::put($blogkey,1);
    	}
    	$randoms=Post::approved()->published()->take(3)->inRandomorder()->get();
    	return view('post-details', compact(['post', 'randoms']));
    }
    function categoryByPost($slug)
    {
        $category= Category::where('slug', $slug)->first();
        $posts=$category->posts()->approved()->published()->simplePaginate(6);
        return view('categories', compact(['category', 'slug', 'posts']));
    }

    public function tagByPost($slug)
    {
         $tag=Tag::where('slug', $slug)->first();
         $posts = $tag->posts()->approved()->published()->simplePaginate(6);
         return view('tags', compact(['tag', 'slug', 'posts']));
    }
}
