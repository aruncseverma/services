<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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
     * guard login routes
     *
     * @var array
     */
    protected $guardLoginRoutes = [
        'default' => 'login',
        'admin'   => 'admin.auth.login_form',
        'escort_admin' => 'escort_admin.auth.login_form',
        'agency_admin' => 'agency_admin.auth.login_form',
        'member_admin' => 'member_admin.auth.login_form',
    ];

    /**
     * error namespaces for each route prefixes
     *
     * @var array
     */
    protected $errorViewNamespaces = [
        'admin*' => 'Admin',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // add notification for validation
        if ($exception instanceof ValidationException) {
            app('notify')->error($exception->getMessage());
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return parent::unauthenticated($request, $exception);
        }

        // overrides to redirect to route based on guard defined
        return redirect()->guest(
            route(
                $this->getGuardLoginRoute($exception->guards()[0]),
                [
                    'redirect_url' => $request->fullUrl()
                ]
            )
        );
    }

    /**
     * get login route for auth guard name
     *
     * @param  string $guard
     * @return string
     */
    protected function getGuardLoginRoute(string $guard = 'default') : string
    {
        return (array_key_exists($guard, $this->guardLoginRoutes))
            ? $this->guardLoginRoutes[$guard]
            : $this->guardLoginRoutes['default'];
    }

    /**
     * {@inheritDoc}
     */
    protected function renderHttpException(HttpExceptionInterface $e) : SymfonyResponse
    {
        if ($namespace = $this->getPathErrorViewNamespace()) {
            if (view()->exists($view = "{$namespace}::common.errors.{$e->getStatusCode()}")) {
                return response()->view($view, [
                    'errors' => new ViewErrorBag,
                    'exception' => $e,
                    'disableMainWrapper' => true,
                    'title' =>$e->getMessage(),
                ], $e->getStatusCode(), $e->getHeaders());
            }
        }

        return parent::renderHttpException($e);
    }

    /**
     * retrieved error view namespace based on route
     *
     * @return null|string
     */
    protected function getPathErrorViewNamespace()
    {
        $request = app('request');

        foreach ($this->errorViewNamespaces as $path => $namespace) {
            if ($path !== '/') {
                $path = trim($path, '/');
            }

            // dd($path, $request->fullUrlIs($path), $request->is($path));

            if ($request->fullUrlIs($path) || $request->is($path)) {
                return $namespace;
            }
        }

        return;
    }
}
