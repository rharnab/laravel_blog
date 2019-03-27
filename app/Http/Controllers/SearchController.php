<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class SearchController extends Controller
{
    public function search(Request $request)
    {
    	$search=$request->search;

    	$posts = Post::approved()->published()->where('title', 'LIKE', '%'.$search.'%')->get();
    	return view('search', compact(['posts', 'search']));
    }
}
