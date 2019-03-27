<?php

namespace App\Http\Controllers\Author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class favoriteController extends Controller
{
    public function index()
    {
    	$posts=Auth::user()->favorite_posts;
    	return view('admin.favorite', compact('posts'));
    	
    }
}
