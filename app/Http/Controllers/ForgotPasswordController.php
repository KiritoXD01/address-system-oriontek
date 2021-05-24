<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function submitForgotPassword(Request $request)
    {
        Validator::make($request->all(), [
            'email' => ['required', 'email:rfc', 'exists:users']
        ])->validate();

        $token = Str::random(64);

        DB::table("password_resets")->insert([
            'email' => strtolower($request->email),
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('emails.forgotPassword', ['token' => $token], function($message) use ($request) {
            $message->to($request->email);
            $message->subject("Reset Password");
        });

        return back();
    }

    public function showResetPassword(string $token)
    {
        return view('auth.reset', compact('token'));
    }

    public function submitResetPasswordForm(Request $request)
    {
        Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required']
        ])->validate();

        $updatePassword = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token
        ]);

        if (!$updatePassword) return back()->withInput()->with('error', 'Invalid token!');

        User::where('email', $request->email)->update(['password' => bcrypt($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/login')->with('message', 'Your password has been changed!');
    }
}
