<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        //     if (in_array(Auth::user()->role->role->slug, $roles)) {
        //         return $next($request);
        //     }
        //     return redirect('/');
        // }



        if (!$request->user() || !$request->user()->roles()->whereIn('slug', $roles)->exists()) {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}
