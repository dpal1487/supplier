<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // dd($request->users);
        // Log::info("User roles: " . implode(', ', $request->user() ?  $request->user()->roles : null));
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
