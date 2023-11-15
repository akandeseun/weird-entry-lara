<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response([
                    "message" => "Unauthorized"

                ], 500);
            }
        } catch (JWTException $e) {
            return response([
                "error" => "omo jwt error oo",
                "message" => $e->getMessage()
            ], 500);
        }
        return $next($request);
    }
}
