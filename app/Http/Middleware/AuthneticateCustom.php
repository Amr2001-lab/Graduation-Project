<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateCustom
{
    public function handle(Request $request, Closure $next)
    {
        // If the user isn't logged in...
        if (!$request->session()->has('user_id')) {
            // or if using Laravel’s built-in Auth: if (!auth()->check())
            return redirect()->route('login.show');
        }

        return $next($request);
    }
}
