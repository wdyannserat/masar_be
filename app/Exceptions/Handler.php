<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\FileUploader;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use FileUploader;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $code =  $e->getCode();
        $msg  =  $e->getMessage();

        // if ($e instanceof UnauthorizedException) {
        //     $code =  403;
        // } else
         if ($e instanceof ValidationException) {
            $msg = $e->validator->errors()->first();
            $code = 400;
        } else if ($e instanceof NotFoundHttpException) {
            $code = 404;
            $msg = __('messages.RouteNotFound');
        } else if ($e instanceof AuthenticationException) {
            $code = 401;
            $msg = __('messages.Unauthenticated');
        }

        if (isset(request()->myFiles)) {
            foreach (request()->myFiles as $filePath) {
                $this->deleteFile($filePath);
            }
        }


        if (!$code || $code > 599 || $code <= 0 || gettype($code) !== "integer") {
            $code = 500;
        }
        return response()->json([
            'status' => 'Error',
            'message' => $msg , //isset($msg) ? __('messages.' . $msg) : null,
            'data' => null,
            'returnedCode' => $code
        ], $code);
    }
}