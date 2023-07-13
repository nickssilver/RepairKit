<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;
use Exception;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request request
     * @param Closure $next    next
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        if (strpos($request->route()->uri, 'api/admin') === false) {
            return $next($request);
        }

        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['message' => __('Unauthorized')], 401);
        }

        $user = Auth::guard('sanctum')->user();

        if (!$user->userRole->checkPermission($request->get('gate'))) {
            return response()->json(
                ['message' => __('Forbidden, the server refuses to authorize')],
                403
            );
        }

        return $next($request);
    }
}
