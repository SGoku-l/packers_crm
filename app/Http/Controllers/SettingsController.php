<?php

namespace App\Http\Controllers;

use App\Models\ProfilePic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\User;

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

}
