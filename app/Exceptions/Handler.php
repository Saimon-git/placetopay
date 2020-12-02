<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

/**
 * Class Handler.
 */
class Handler extends ExceptionHandler
{
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
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        \Nuwave\Lighthouse\Exceptions\AuthenticationException::class,
        \Laravel\Nova\Exceptions\AuthenticationException::class,
        \League\OAuth2\Server\Exception\OAuthServerException::class,
        \NotificationChannels\Fcm\Exceptions\CouldNotSendNotification::class,
        \Laravel\Passport\Exceptions\OAuthServerException::class,
    ];

    /**
     * @param \Exception $exception
     *
     * @throws \Exception
     *
     * @return mixed|void
     */
    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception) && 'local' !== config('app.env') && 'testing' !== config('app.env')) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     *
     * @throws \Nuwave\Lighthouse\Exceptions\AuthenticationException
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            if (! $request->wantsJson()) {
                return redirect('login');
            }
        }
        if ($exception instanceof AuthenticationException) {
            throw new \Nuwave\Lighthouse\Exceptions\AuthenticationException();
        }

        return parent::render($request, $exception);
    }
}
