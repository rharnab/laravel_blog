<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sibscribe;
use Brian2694\Toastr\Facades\Toastr;


class SubscriberController extends Controller
{
    public function store(Request $request)
    {
    	$this->validate($request, [

    		'email'=>'required|email|unique:sibscribes',

    	]);

    	$subscriber=new Sibscribe;
    	$subscriber->email=$request->email;
    	$subscriber->save();

    	Toastr::success('your subscribe succesfull');
    	return redirect()->back();


    }
}
