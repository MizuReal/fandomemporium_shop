<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
    if(Auth::check())
    {
        if(Auth::user()->is_admin == 1 && Auth::user()->status == 0)
        {
            return $next($request);
        }
        else if(Auth::user()->is_admin == 1 && Auth::user()->status == 1)
        {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Your account has been deactivated. Please contact administrator.');
        }
        else
        {
            return redirect()->route('admin.login')->with('error', 'You do not have admin access.');
        }
    }
    else
    {
        return redirect()->route('admin.login')->with('error', 'You do not have admin access.');
    }

}

}