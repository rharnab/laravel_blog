<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Session;
class PostController extends Controller
{
	public function index()
	{
		$posts=Post::latest()->simplepaginate(6);
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
    	$randoms=Post::all()->random(3);
    	return view('post-details', compact(['post', 'randoms']));
    }
}
