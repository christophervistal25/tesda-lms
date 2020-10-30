<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
          // To avoid visiting the login section of other user if already logged in
         if (Auth::guard('admin')->check()) {
              return redirect()->intended(route('admin.dashboard'));
         } else if (Auth::guard('admin')->check()) {
             return redirect()->intended(route('admin.dashboard'));
         } 

        switch ($guard) {

          case 'admin':
            if (Auth::guard($guard)->check()) {
              return redirect()->route('admin.dashboard');
            }
            break;

          default:
            if (Auth::guard($guard)->check()) {
                return redirect()->route('site.home');
            }
            break;

        }
        
        return $next($request);
    }
    
}
