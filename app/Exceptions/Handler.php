<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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

    public function render($request, Throwable $exception)
    {
        $message = $exception->getMessage();
        $code = $exception->getCode() ? $exception->getCode() : 500;

        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $ids = join(",", $exception->getIds());
            $message = "No results found with id '" . $ids . "'";
        } else if ($exception instanceof \Illuminate\Database\QueryException) {
            $code = 500;
            $message = $exception->getMessage();
        }

        return response()->json([
            'responseMessage' => $message
        ], $code);
    }
}
