<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class PreventRegister
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
        $setting = Setting::find(1);

        if (!e($setting->app_user_registration ? true : false)) {
            return response()->json(['message' => __('Forbidden')], 403);
        }
        return $next($request);
    }
}
