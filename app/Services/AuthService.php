<?php


namespace App\Services;

use App\Models\User;
use App\Notifications\EmailVerification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class AuthService
{
  public function register(Request $request)
  {
    Validator::make($request->all(), [
      'first_name' => ['required', 'string', 'max:255'],
      'last_name' => ['required', 'string', 'max:255'],
      'address' => ['required', 'string'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'password_confirmation' => ['required']
    ])->validate();

    $user = User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'address' => $request->address,
      'email' => $request->email,
      'password' => Hash::make($request->password)
    ]);

    $token = Auth::login($user);

    $url = config('app.url') . "/confirm-email?token={$token}";

    // $user->notify(new EmailVerification($url));
    Notification::send($user, new EmailVerification($url));

    return (object)[
      "message" => "User created",
      "token" => $token,
      "info" => "A verify mail link has been sent to your mail address"
    ];
  }

  public function login(Request $request)
  {
    Validator::make($request->all(), [
      'email' => ['required', 'string', 'email'],
      'password' => ['required', 'string']
    ])->validate();

    $credentials = $request->only(['email', 'password']);

    if (!$token = Auth::attempt($credentials)) {
      abort(400, 'Invalid Login details');
    }

    return (object)[
      "user" => Auth::user(),
      "token" => $token
    ];
  }

  public function confirmEmail()
  {

    /** @var \App\Models\User */
    $user = Auth::user();

    if ($user->email_verified_at !== null) {
      return response()->json([
        "message" => "Email verified already"
      ]);
    }

    $user->email_verified_at = now();
    $user->save();

    return (object)[
      "message" => "Email verified successfully"
    ];
  }
}
