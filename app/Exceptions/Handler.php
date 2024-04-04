<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $model = app($e->getModel());
            $modelName = class_basename($model);
            $errorMessage = __('errors.' . $modelName . '.not_found');
            if ($errorMessage == 'errors.' . $modelName . '.not_found') {
                $errorMessage = __('errors.default.model_not_found', ['name' => $modelName]);
            }
            return response()->json([
                'statusCode' => 404,
                'message' => $errorMessage,
                'content' => null,
            ], 404);
        }
        if ($e instanceof HttpException) {
            return response()->json([
                'statusCode' => $e->getStatusCode(),
                'message' => $e->getMessage(),
                'content' => null,
            ], $e->getStatusCode());
        }

        // Handle other exceptions
        return response()->json([
            'statusCode' => 500,
            'message' => $e->getMessage() . ', ' . $e->getFile() . ':' . $e->getLine(),
            'content' => null,
        ], 500);
    }
}
