<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * @param Request $request
     * @param Throwable $exception
     * @return JsonResponse
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof TokenInvalidException) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof TokenExpiredException) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof JWTException) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof \Exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
