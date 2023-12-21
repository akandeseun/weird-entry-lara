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
    public function register(Request $request, $is_admin = false)
    {
        $result = $this->authService->register($request, $is_admin);

        return response()->json($result);
    }

    public function login(Request $request, $is_admin = false)
    {
        $result = $this->authService->login($request, $is_admin);

        return response()->json($result);
    }

    public function logout()
    {
        $result = $this->authService->logout();

        return response()->json($result);
    }

    public function adminRegister(Request $request)
    {
        return $this->register($request, true);
    }
    public function adminLogin(Request $request)
    {
        return $this->login($request, true);
    }


    public function confirmEmail()
    {
        $result = $this->authService->confirmEmail();

        return response()->json($result);
    }
}
