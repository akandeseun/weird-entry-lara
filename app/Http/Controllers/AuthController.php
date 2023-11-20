<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

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

        $url = config('app.url') . "/confirm-email?token={$token}";

        // $user->notify(new EmailVerification($url));
        Notification::send($user, new EmailVerification($url));

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

    public function confirmEmail()
    {

        if (Auth::user()->email_verified_at !== null) {
            return response([
                "message" => "Email verified already"
            ]);
        }
        $user = User::findOrFail(Auth::id());

        $user->email_verified_at = now();

        $user->save();

        return response([
            "message" => "Email verified successfully"
        ]);
    }
}
