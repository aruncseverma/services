<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * guard routes
     *
     * @var array
     */
    protected $guardRoutes = [
        'default' => '',
        'admin'   => 'admin.dashboard',
        'escort_admin' => 'escort_admin.dashboard',
        'agency_admin' => 'agency_admin.dashboard',
        'member_admin' => 'member_admin.dashboard',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect()->route($this->getGuardRoute($guard));
        }

        return $next($request);
    }

    /**
     * get defined guard route from $this::guardRoutes
     *
     * @param  string $guard
     *
     * @return string
     */
    protected function getGuardRoute($guard = 'default') : string
    {
        return (array_key_exists($guard, $this->guardRoutes))
            ? $this->guardRoutes[$guard]
            : $this->guardRoutes['default'];
    }
}
