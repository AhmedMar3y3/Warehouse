<?php

namespace App\Http\Controllers\User;

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
    public function register(storeUserRequest $request)
    { 
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);     
        $verificationCode = mt_rand(100000, 999999);
        $user->verification_code = $verificationCode;
        $user->save();
        
        Mail::raw("رمز التحقق من البريد الإلكتروني الخاص بك هو: $verificationCode", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('تحقق من بريدك الإلكتروني');
        });
        
        return response()->json([
            'verification_code' => $user->verification_code,
            'message' => '. تم التسجيل بنجاح , يرجى التحقق من بريدك الإلكتروني باستخدام الرمز المرسل إلى بريدك الإلكتروني'
        ], 201);
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
            return response()->json('رمز التحقق أو البريد الإلكتروني غير صالح', 400);
        }

        $user->verified_at = now();
        $user->verification_code = null;
        $user->save();

        return response()->json('تم التحقق من البريد الإلكتروني بنجاح', 200);
    }

    public function login(loginUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::where('email', $request->input('email'))->first();
        if (!$user || !Hash::check($request->input('password'), $user->password))
        {
            return response()->json("بيانات الاعتماد غير متطابقة", 404);
        }
        if (is_null($user->verified_at))
        {
            return response()->json([
                'message' => 'يرجى التحقق من بريدك الإلكتروني قبل تسجيل الدخول.'
            ], 403);
        }
        $token = $user->createToken('رمز API الخاص بـ ' . $user->name)->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(
            (Auth::user()->name . '، لقد تم تسجيل خروجك بنجاح وتم حذف رمزك'), 200
        );
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json('المستخدم غير موجود', 404);
        }
    
        $code = mt_rand(100000, 999999);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $code,
                'created_at' => now()
            ]
        );
    
        Mail::raw("رمز إعادة تعيين كلمة المرور الخاص بك هو: $code", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('رمز إعادة تعيين كلمة المرور');
        });
    
        return response()->json('تم إرسال رمز إعادة تعيين كلمة المرور إلى بريدك الإلكتروني', 200);
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
            return response()->json('رمز غير صالح', 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return response()->json('تم إعادة تعيين كلمة المرور بنجاح', 200);
    }
}
