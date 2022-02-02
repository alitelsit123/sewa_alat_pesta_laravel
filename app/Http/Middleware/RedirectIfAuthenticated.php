<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = Auth::user();
        // foreach ($guards as $guard) {
        if ($guards) {
            if($request->route()->getName() == 'admin.login-form') {
                return redirect(RouteServiceProvider::HOME_ADMIN);
            } elseif($request->route()->getName() == 'login-form') {
                return redirect(RouteServiceProvider::HOME);
            }
        }
        // }

        return $next($request);
    }
}
