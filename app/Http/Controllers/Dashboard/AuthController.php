<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\storeUserRequest;
use App\Http\Requests\loginUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function loadRegister()
    {
        return view('auth.register');
    }

    public function register(storeUserRequest $request)
    { 
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);     
        $verificationCode = mt_rand(100000, 999999);
        $user->verification_code = $verificationCode;
        $user->save();
        
        Mail::raw("Your email verification code is: $verificationCode", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Verify Your Email');
        });
        
        return redirect()->route('auth.verify-email')->with('success', 'Registration successful, please verify your email ' );

    }
    public function loadVerifyEmail()
    {
        return view('auth.verify-email');
    }
    
 
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verification_code' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)
                    ->where('verification_code', $request->verification_code)
                    ->first();

        if (!$user) {
            return view('auth.verify-email', ['error' => 'Invalid verification code or email']);
        }

        $user->verified_at = now();
        $user->verification_code = null;
        $user->save();

        return redirect()->route('auth.login')->with('success', 'Email verified successfully ' );

    }

    public function loadLogin()
    {
        return view('auth.login');
    }

    public function login(loginUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::where('email', $request->input('email'))->first();
    
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return redirect()->route('auth.login')->withErrors(['error' => 'Credentials do not match']);
        }
    
        if (is_null($user->verified_at)) {
            return redirect()->route('auth.login')->withErrors(['message' => 'Please verify your email before logging in.']);
        }
    
        Auth::login($user); // Log the user in before redirecting
        
        return redirect()->route('dashboard')->with('success', 'Logged in successfully');
    }
    

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return redirect()->route('auth.login')->with('success', 'Logged out successfully');
    }

    public function loadForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return view('auth.forgot-password', ['error' => 'User not found']);
        }
    
        $code = mt_rand(100000, 999999);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $code,
                'created_at' => now()
            ]
        );
    
        Mail::raw("Your password reset code is: $code", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset Code');
        });
    
        return redirect()->route('auth.reset-password')->with('message', 'Password reset code sent to your email');
    }

    public function loadResetPassword()
    {
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
            'password' => 'required|confirmed',
        ]);

        $resetEntry = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$resetEntry) {
            return view('auth.reset-password', ['error' => 'Invalid code']);
        }
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return redirect()->route('auth.login')->with('success', 'Password has been reset successfully ');

    }
}
