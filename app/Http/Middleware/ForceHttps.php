<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request request
     * @param Closure $next    next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.app_https', false) && !$request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }
        return $next($request);
    }
}
