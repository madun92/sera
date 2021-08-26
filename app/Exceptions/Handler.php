<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        // dd($exception);
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // dd($exception);
        // if ($request->wantsJson()) {
            if($exception instanceof ValidationException) {
                return response()->json([
                "error" => true,
                "message" => $exception->validator->getMessageBag()->first(),
                "data" => []
                ]);
            }

            if($exception instanceof UnauthorizedException) {
                return response()->json([
                "error" => true,
                "message" => $exception->getMessage(),
                "data" => []
                ]);
            }

            if($exception instanceof NotFoundHttpException) {
                // dd($exception);
                return response()->json([
                "error" => true,
                "message" =>"Page Not found!",
                "data" => []
                ]);
            }
        // }
        return parent::render($request, $exception);
    }
}
