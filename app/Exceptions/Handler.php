<?php

namespace App\Exceptions;

use Auth;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Mail\Message;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Mail;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        TokenMismatchException::class,
        HttpException::class,
        ValidationException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        if ($this->shouldReport($e) && php_sapi_name() != 'cli') {
            $data = [
                'ip'        => request()->getClientIp(),
                'url'       => request()->fullUrl(),
                'exception' => $e->__toString(),
            ];

            Mail::queue(['text' => 'emails.admin.exception'], $data, function (Message $message) use ($data) {
                $message->subject('Application Exception');
                $message->to(config('upste.owner_email'));
            });
        }

        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof TokenMismatchException) {
            flash()->error('CSRF verification failed, try logging in again.')->important();
            Auth::logout();

            return redirect()->route('login');
        }

        if ($e instanceof MethodNotAllowedHttpException && $request->getMethod() == 'GET') {
            flash()->error('That URL is for POST requests only.');

            return redirect()->route('account');
        }

        return parent::render($request, $e);
    }
}
