<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6|confirmed',
            // 'role_id' => 'required|in:1,2,3' // 1=admin,2=staff,3=student
        ]);
        
        $user = User::create(attributes: [
            'name' => $validation['name'],
            'email' => $validation['email'],
            'phone' => $validation['phone'],
            'password' => bcrypt($validation['password']),
            'password_confirmation' => 'match:password'
            // 'role_id' => $validation['role_id'],
        ]);
         

        $otp = rand(100000, 999999);
        $storeotp = Otp::create([
            'uid' => $user->id,
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);
        $storeotp->save();
        
        // \Mail::raw("Your OTP code is $otp", function ($message) use ($user) {
        //     $message->to($user->email)->subject('OTP Verification');
        // });

        return response()->json([
            'status' => true,
            'message' => 'Registered successfully. Check email for OTP.'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp'   => 'required|digits:6',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $otp = Otp::where('uid', $user->id)->latest()->first();

        if (!$otp || $otp->otp_code !== $request->otp || now()->greaterThan($otp->otp_expires_at)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired OTP'
            ], 422);
        }

        $user->is_phone_verified = true;
        $user->save();

        $otp->delete(); 

        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully'
        ]);
}


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        $user->login_time = now();
        $user->save();

        $request->session()->regenerate();

        cookie::queue('login_time', now()->toDateTimeString(), 60*24);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
            'redirect_url' => match($user->role_id) {
                1 => '/admin/dashboard',
                2 => '/staff/dashboard',
                3 => '/student/dashboard',
                default => '/home',
            }
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->logout_time = now();
            $user->save();

            $user->tokens()->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        cookie()->queue(cookie()->forget('login_time'));

        return response()->json([
            'status' => true,
            'message' => 'Logout successful'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => __($status)]);
        }

        return response()->json(['message' => __($status)], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)]);
        }

        return response()->json(['message' => __($status)], 400);
    }

}
