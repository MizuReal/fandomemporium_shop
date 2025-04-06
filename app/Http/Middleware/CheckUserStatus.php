<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // If user is a customer (not admin) and account is deactivated
            if (Auth::user()->is_admin == 0 && Auth::user()->status == 1) {
                // Logout the user
                Auth::logout();
                
                // Invalidate and regenerate the session
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                // Redirect to homepage with error message and show login modal
                return redirect()->route('home')->with([
                    'error' => 'Your account has been deactivated. Please contact the administrator.',
                    'login_modal' => true
                ]);
            }
        }
        
        return $next($request);
    }
} 