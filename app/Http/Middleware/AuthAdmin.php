<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if(!$user) {
            return redirect(route('admin.login-form'));
        } else {
            if(!$user->isAdmin()) {
                return redirect(route('admin.login-form'));
            }
        }
        return $next($request);
    }
}
