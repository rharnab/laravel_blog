<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sibscribe;
use Brian2694\Toastr\Facades\Toastr;


class SubscriberController extends Controller
{
    public function index()
    {
    	$subscribes=Sibscribe::get();
    	return view('admin.subscribe', compact('subscribes'));
    }

    public function destroy($id)
    {
    	$subscribe=Sibscribe::findorfail($id);
    	$subscribe->delete();
    	return redirect()->back();

    	toastr::success('Subscriber delete successfull');
    	return redirect()->back();
    }
}
