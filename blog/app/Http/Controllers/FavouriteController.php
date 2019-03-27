<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function add($post)
    {
    	$user=Auth::user();

    	$favorite=$user->favorite_posts()->where('post_id', $post)->count();
    	if($favorite ==0)
    	{
    		$user->favorite_posts()->attach($post);
    		Toastr::success('Favorite post added');
    		return redirect()->back();
    	}
    	else{
    		$user->favorite_posts()->detach($post);
    		Toastr::success('Favorite post removed');
    		return redirect()->back();

    	}

    }
}
