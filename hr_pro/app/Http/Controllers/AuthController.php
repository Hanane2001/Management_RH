<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister(){
        return view('auth.register');
    }

    public function register(RegisterRequest $request){
        $otp = rand(100000, 999999);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role_id' => 3,
            'department_id' => $request->department_id,
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        Mail::raw("Your OTP is: $otp", function($message) use ($user){
            $message->to($user->email)->subject('OTP Verification');
        });
        session(['user_temp' => $user->id]);
        return redirect('/otp');
    }
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials');
        }
        $otp = rand(100000, 999999);
        $user->update(['otp_code' => $otp,'otp_expires_at' => now()->addMinutes(5)]);

        Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('OTP Verification');
        });

        session(['user_temp' => $user->id]);

        return redirect('/otp');
    }
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }

    //----------------------otp------------------------
    public function showOtp()
    {
        return view('auth.otp');
    }
    public function verifyOtp(Request $request)
    {
        $user = User::find(session('user_temp'));
        if (!$user) {
            return redirect('/login')->with('error', 'Utilisateur non trouvé');
        }

        if ($user->otp_code && $user->otp_code == $request->otp && now()->lessThan($user->otp_expires_at)) {
            $user->update([
                'email_verified_at' => now(),
                'otp_code' => null,
                'otp_expires_at' => null
            ]);

            Auth::login($user);
            session()->forget('user_temp');

            return redirect('/dashboard');
        }
        return back()->with('error', 'Invalid or expired OTP');
    }
}
