<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class SettingController extends Controller
{
    public function index()
    {
    	return view('admin.setting');
    }

    public function profile_update(Request $request)
    {
    	 $this->validate($request, [
    	 		'name'=>'required',
    	 		'email'=>'required|email'
    	 		
    	 		
    	 ]);

    	 $user=User::findOrfail(Auth::id());
    	 $slug=str_slug($request->name);
    	 $image=$request->file('image');

    	 if($image)
    	 {
            $today=Carbon::now()->toDateString();
            $imageName=$today.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            

            if(!Storage::disk('public')->exists('profile'))
            {
                Storage::disk('public')->makeDirectory('profile');
            }

            if(Storage::disk('public')->exists('profile/'.$user->image))
            {
                Storage::disk('public')->delete('profile/'.$user->image);
            }

            $profile=Image::make($image)->resize(500,500)->stream();
            Storage::disk('public')->put('profile/'.$imageName, $profile);

    	 	
    	 }
    	 else{
    	 	$imageName='default.png';
    	 }

         $user->name=$request->name;
         $user->email=$request->email;
         $user->image=$imageName;
         $user->about=$request->about;
         $user->save();

         Toastr::success('profile update success');
         return redirect()->back();


    }

    public function password_update(Request $request)
    {
        $this->validate($request, [
            'old_password'=>'required',
            'password'=>'required|confirmed'
            

        ]);

       
        $hashPassword=Auth::user()->password;

        if(Hash::check($request->old_password, $hashPassword))
        {
            if(!Hash::check($request->password, $hashPassword))
            {
                $user=User::find(Auth::id());
                
                $user->password=Hash::make($request->password);
                $user->save();

                Toastr::success('Password update success');
                Auth::logout();
                return redirect()->back();

            }
            else{
                Toastr::error('Password not Changed');
                return redirect()->back();
            }
        }
    }



}
