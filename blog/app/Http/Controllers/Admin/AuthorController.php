<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class AuthorController extends Controller
{
    public function index()
    {
    	$authors = User::Authors()
    		->withCount('posts')
    		->withCount('favorite_posts')
    		->withCount('comments')
    		->get();

    	return view('admin.authors', compact('authors'));
    }

    
}
