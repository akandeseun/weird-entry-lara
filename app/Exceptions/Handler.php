<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
        $this->renderable(function (\Exception $e, $request) {
            if ($e instanceof NotFoundHttpException) {
                return response()->json(['message' => 'Resource Not found'], 404);
            }
            if ($e instanceof HttpException) {
                return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
            }
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized.'], 400);
        }

        return response()->json(['message' => 'Unauthenticated.'], 401);
    }
}
