<?php

namespace App\Exceptions;

use App\Http\Responses\NotFoundResponse;
use App\Http\Responses\UnauthorizedResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return new NotFoundResponse();
            }
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return new UnauthorizedResponse();
    }
}
