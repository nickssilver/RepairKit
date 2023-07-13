<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDemoMode
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
        if (config('app.demo_mode')) {
            return response()->json(
                ['message' => 'Action performed successfully but changes are disabled while mode'],
                200
            );
        }
        return $next($request);
    }
}
