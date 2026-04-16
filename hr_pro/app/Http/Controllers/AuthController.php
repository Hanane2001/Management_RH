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
    private function generateOTP(): int{
        return rand(100000, 999999);
    }

    private function sendOtpEmail(User $user, string $otp, string $subject): void{
        try {
            Mail::raw("Your OTP code is: $otp\n\nThis code will expire in 5 minutes.", function ($message) use ($user, $subject) {
                $message->to($user->email)->subject($subject);
            });
        } catch (\Exception $e) {
            \Log::error("Email sending failed: " . $e->getMessage());
            \Log::info("OTP for {$user->email}: {$otp}");
        }
    }

    private function setUserOtp(User $user, string $sessionKey = 'user_temp'): void{
        $otp = $this->generateOTP();
        $user->update([
            'otp_code' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(5)
        ]);
        $this->sendOtpEmail($user, $otp, 'OTP Verification');
        session([$sessionKey => $user->id]);
    }

    private function clearUserOtp(User $user): void{
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null
        ]);
    }

    private function getSessionUser(string $sessionKey): ?User{
        $userId = session($sessionKey);
        if (!$userId) {
            return null;
        }
        $user = User::find($userId);
        if (!$user) {
            session()->forget($sessionKey);
            return null;
        }
        return $user;
    }

    private function verifyOtpCode(User $user, string $otp): bool{
        return $user->otp_code && Hash::check($otp, $user->otp_code) && now()->lessThan($user->otp_expires_at);
    }

    public function showRegister(){
        return view('auth.register');
    }

    public function register(RegisterRequest $request){
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role_id' => User::ROLE_EMPLOYEE,
            'department_id' => $request->department_id,
            'is_active' => true,
        ]);

        $this->setUserOtp($user);
        return redirect('/otp');
    }

    public function showLogin(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials');
        }
        if (!$user->is_active) {
            return back()->with('error', 'Account disabled');
        }
        $this->setUserOtp($user);
        return redirect('/otp');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showOtp(){
        return view('auth.otp');
    }

    public function verifyOtp(Request $request){
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = $this->getSessionUser('user_temp');
        if (!$user) {
            return redirect('/login')->with('error', 'User not found');
        }

        if ($this->verifyOtpCode($user, $request->otp)) {
            $user->update([
                'email_verified_at' => now()
            ]);
            $this->clearUserOtp($user);
            Auth::login($user);
            $request->session()->regenerate();
            session()->forget('user_temp');
            return redirect('/dashboard');
        }

        return back()->with('error', 'Invalid or expired OTP');
    }

    public function showForgotPassword(){
        return view('auth.forgot');
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email not found');
        }

        $this->setUserOtp($user, 'reset_user');
        return redirect('/reset-otp');
    }

    public function showResetOtp(){
        return view('auth.reset-otp');
    }

    public function verifyResetOtp(Request $request){
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = $this->getSessionUser('reset_user');
        if (!$user) {
            return redirect('/login')->with('error', 'User not found');
        }

        if ($this->verifyOtpCode($user, $request->otp)) {
            session(['reset_verified' => true]);
            return redirect('/change-password');
        }

        return back()->with('error', 'Invalid or expired OTP');
    }

    public function showChangePassword(){
        if (!session('reset_verified')) {
            return redirect('/login');
        }
        return view('auth.change-password');
    }

    public function changePassword(Request $request){
        if (!session('reset_verified')) {
            return redirect('/login');
        }
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);
        $user = $this->getSessionUser('reset_user');
        if (!$user) {
            return redirect('/login');
        }
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        $this->clearUserOtp($user);
        session()->forget(['reset_user', 'reset_verified']);
        return redirect('/login')->with('success', 'Password changed successfully');
    }
}