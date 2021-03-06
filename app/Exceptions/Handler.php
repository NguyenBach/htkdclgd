<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     */
    public function render($request, Exception $exception)
    {
        Log::error($exception->getMessage());
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'code' => 404,
                'message' => $exception->getMessage(),
            ], 404);
        }
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'code' => 404,
                'message' => $exception->getMessage(),
            ], 404);
        }
        if ($exception instanceof ValidationException) {
            return response()->json([
                'code' => 400,
                'message' => $exception->getMessage(),
            ], 400);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'code' => 403,
                'message' => $exception->getMessage(),
            ], 403);
        }
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'code' => 401,
                'message' => $exception->getMessage(),
            ], 401);
        }

        if($exception instanceof UnauthorizedHttpException){
            return response()->json([
                'code' => 401,
                'message' => $exception->getMessage(),
            ], 401);
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'code' => 401,
                'message' => $exception->getMessage(),
            ], 401);
        }
        if ($exception instanceof JWTException) {
            return response()->json([
                'code' => 401,
                'message' => $exception->getMessage(),
            ], 401);
        }

//        return parent::render($request,$exception);
        return response()->json([
            'code' => 500,
            'message' => $exception->getMessage(),
            'trace' => $exception->getTrace()
        ], 500);
    }
}
