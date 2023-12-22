<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{

    public function handle($request, Closure $next, ...$roles)
    {
        Log::info("RoleMiddleware is being executed");

        $userRoles = $request->user()->roles()->whereIn('name', $roles)->get();
        Log::info("User roles: " . json_encode($userRoles->pluck('name')->all()));

        if (!$userRoles->isEmpty()) {
            Log::info("Role check passed");
            return $next($request);
        }

        Log::info("Role check failed");
        abort(403, 'Unauthorized.');
        // if (!$request->user() || !$request->user()->roles()->whereIn('name', $roles)->exists()) {
        //     abort(403, 'Unauthorized.');
        // }

        // return $next($request);
    }

    // public function handle($request, Closure $next, ...$roles)
    // {
    //     if (in_array(Auth::user()->role->role->slug, $roles)) {
    //         dd($roles);
    //         return $next($request);
    //     }
    //     return redirect('/');
    // }

    // public function handle($request, Closure $next, $role, $permission = null)
    // {
    //     if (!$request->user()->hasRole($role)) {
    //         abort(404);
    //     }

    //     if ($permission != null && !$request->user()->can($permission)) {
    //         abort(404);
    //     }

    //     return $next($request);
    // }
}
