<?php

namespace App\Http\Controllers;

use App\Models\ProfilePic;
use App\Models\SiteImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function profilepage(){

        return view('admin.profile-setting');

    }

    public function profileImage(Request $request){

       $request->validate([
            'profileimage' => 'required|image|mimes:jpg,jpeg,png|max:2048'
       ]);

       $user = Auth::user();

       $profile = ProfilePic::where('uid',$user->id)->first();

       if ($profile && File::exists(public_path('uploads/profile/' . $profile->profile_pic))) {

            File::delete(public_path('uploads/profile/' . $profile->profile_pic));

       }

       $file = $request->file('profileimage');
       $filename = time() . '.' . $file->getClientOriginalExtension();
       $file->move(public_path('uploads/profile'),$filename);

       if ($profile) {
            $profile->update(['profile_pic' => $filename]);
        } else {
            ProfilePic::create([
                'uid' => $user->id,
                'profile_pic' => $filename
            ]);
        }

       return response()->json([
            'status' => true,
            'message' => 'Profile Image Updated Successfully',
            'image_url' => asset('uploads/profile/' . $filename),
            'user_id' => $user->id,
            'timestamp' => now()->toDateTimeString()
       ],200);

    }

    public function profileInformation(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:20',
        ]);

        $user = User::find(Auth::id());

        if($user){
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile info updated successfully',
        ]);

    }

    public function profilechangepassword(Request $request){

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();

        if(!Hash::check($request->current_password,$user->password)){

            return response()->json([
                'status' => false,
                'message' => 'Current Password is Invalid'
            ]);

        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        Auth::logout();
        Session::flush();

        return response()->json([
            'status' => true,
            'message' => 'New Password Updated Successfully. Please Login Again',
            'redirect' => route('login')
        ]);

    }

    public function siteImage(Request $request){

        $request->validate([
            'siteimage' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $siteimage = SiteImage::where('id',1)->first();

        if($siteimage && File::exists(public_path('uploads/site/' . $siteimage->site_image))){

            File::delete(public_path('uploads/site/' . $siteimage->site_image));

        }

        $file = $request->file('siteimage');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/site'),$filename);

        if($siteimage){
            $siteimage->update([
                'site_image' => $filename
            ]);
        }else{
            SiteImage::create([
                'site_image' => $filename
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Site Image Updated Successfully',
            'site_url' => asset('uploads/site/' . $filename),
        ]);

    }

}
