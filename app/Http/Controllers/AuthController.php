<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'address' => $validatedData['address'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);

        $token = Auth::login($user);
        // $token = auth()->login($user);


        // sends users a verify email link
        // event(new Registered($user));

        return response([
            "message" => "User created",
            "token" => $token,
            "info" => "A verify mail link has been sent to your mail address"
        ]);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = [
            'email' => $validatedData['email'],
            'password' => $validatedData['password']
        ];

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response(["message" => "Invalid Login details"], 400);
        }

        return response([
            "data" => [
                "user" => Auth::user(),
                "token" => $token,
            ]
        ]);
    }

    public function me()
    {
        return response([
            "user" => Auth::user()
        ]);
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return response([
            "message" => "Mail Verified"
        ]);
    }

    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return response([
            "message" => "Verification link sent"
        ]);
    }
}
