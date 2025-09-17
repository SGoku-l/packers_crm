<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Models\Otp;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;

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
        
        $user = User::create( [
            'name' => $validation['name'],
            'email' => $validation['email'],
            'phone' => $validation['phone'],
            'password' => bcrypt($validation['password'])
            // 'role_id' => $validation['role_id'],
        ]);
         

        $otp = rand(100000, 999999);
        $storeotp = Otp::create([
            'user_id' => $user->id,
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
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        $otp = Otp::where('user_id', $user->id)->latest()->first();

        if (!$otp || $otp->otp_code !== $request->otp || now()->greaterThan($otp->otp_expires_at)) {
           return redirect('admin/login');
        }

        $user->is_phone_verified = true;

        LoginLog::where('user_id',$user->id)->where('login_otp_verifi_status','pending')->latest()->first()?->update([
            'login_otp_verifi_status' => 'success',
            'logged_in_at' => now(),
        ]);
       
        $user->save();
        Auth::login($user);
        $user->tokens()->delete();

        $user->createToken('auth_token')->plainTextToken;
        $user->login_time = now();
        $user->current_session_id = session()->getId();
        $user->session_expires_at = now()->addDays(7);
        $user->save();
        
        $request->session()->put('rememberToken', session()->getId());
        $request->session()->put('user_id', $user->id);
        $request->session()->put('login_time', now());
        $request->session()->put('session_expires_at', now()->addWeek());

        // return response()->json([
        //     'status' => true,
        //     'message' => 'OTP verified successfully,Login Successfully',
        //     'redirect_url' => 'index',
        //     'sessionToken' => $token,
        //     'tokenType' => 'bearer',
        //     'user' => $user->id,
        //     'session_expires_at' => $user->session_expires_at,
        // ]);

        return redirect('admin/dashboard')->with('toasts', [
        ['type' => 'success', 'message' => 'Login Successfully', 'time' => now()->format('H:i')]]);
    }

    public function login(Request $request)
    {
         $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // if (!Auth::attempt($credentials)) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Invalid credentials'
        //     ], 401);
        // }

        $agent = new Agent();
        $mail = $request->email;
        
        $user = User::where('email',$mail)->first();

        if(!$user || !Hash::check($request->password,$user->password)){
            return back()->withErrors(['email'=>'Invalid Credentials']);
        }

         LoginLog::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'device_name' => $agent->device() ?: 'unknown',
            'login_otp_verifi_status' => 'pending'
         ]);

        // $user->tokens()->delete();

        // $token = $user->createToken('auth_token')->plainTextToken;

        $otp = rand(100000,999999);
        $storeotp = Otp::create([
            'user_id' => $user->id,
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);
        $storeotp->save();

        Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));

        return view('admin.otp',['user'=>$mail,
            'toasts' => [
            ['type' => 'success', 'message' => 'OTP Sent Successfully', 'time' => now()->format('H:i')]
            ]
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

        if(Auth::check()){
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $token = $request->user()?->currentAccessToken();
        if ($token instanceof \Laravel\Sanctum\PersonalAccessToken) {
            $token->delete();
        }

        cookie()->queue(cookie()->forget('login_time'));

        return redirect('admin/login')->with('toasts', [
        ['type' => 'success', 'message' => 'Logout Successfully', 'time' => now()->format('H:i')]]);;
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
