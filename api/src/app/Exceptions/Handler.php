<?php

namespace App\Exceptions;

use Domain\Exception\NotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;
use Symfony\Component\HttpFoundation\Response as StatusCode;

class Handler extends ExceptionHandler
{
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
     * @param Throwable $exception
     * @param Request $request
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $exception, Request $request) {
            if ($request->is('api/*')) {
                $class = get_class($exception);
                switch ($class) {
                    case NotFoundException::class:
                        return response()->json(
                            ['message' => $exception->getMessage()],
                            StatusCode::HTTP_NOT_FOUND
                        );
                }
            }
        });
    }
}
