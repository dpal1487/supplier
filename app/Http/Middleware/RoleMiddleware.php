<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role, $permission = null)
    {
        // if (in_array(Auth::user()->role->role->slug, $roles)) {
        //     return $next($request);
        // }
        // return redirect('/');

        if (!$request->user()->hasRole($role)) {
            abort(404);
        }

        if ($permission != null && !$request->user()->can($permission)) {
            abort(404);
        }

        return $next($request);
    }
}
