<?php

namespace App\Http\Middleware;

use App\Services\SSO;
use Closure;

class SsoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        (new SSO())->login();

        return $next($request);
    }
}
