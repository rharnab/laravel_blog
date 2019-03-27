<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;


class AuthorController extends Controller
{
    public function author_profile($user_name)
    {
    	 $author = User::where('user_name', $user_name)->first();
    	 $posts = $author->posts()->approved()->published()->simplePaginate(6);
    	 return view('author_profile', compact(['author', 'posts']));
    }
}
