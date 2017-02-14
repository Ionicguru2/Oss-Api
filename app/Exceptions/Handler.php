<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
	    switch ($e) {

            case ($e->getStatusCode() == 404):
                $code = config('oss.messages.NOT_FOUND.code');
                $message = config('oss.messages.NOT_FOUND.message');
                break;

            case ($e->getStatusCode() == 403):
                $code = config('oss.messages.NOT_AUTHORIZED.code');
                $message = config('oss.messages.NOT_AUTHORIZED.message');
                break;

            default:
                $code = config('oss.messages.INTERNAL_SERVER.code');
                $message = config('oss.messages.INTERNAL_SERVER.message');
                break;
        }

        return response()->json($message, $code);
	}

}
