<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }
    //
    public function register(Request $request)
    {
        $result = $this->authService->register($request);

        return response()->json($result);
    }

    public function login(Request $request)
    {
        $result = $this->authService->login($request);

        return response()->json($result);
    }



    public function confirmEmail()
    {
        $result = $this->authService->confirmEmail();

        return response()->json($result);
    }
}
