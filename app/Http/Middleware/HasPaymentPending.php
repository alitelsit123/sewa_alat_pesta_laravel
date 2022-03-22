<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasPaymentPending
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if($user) {
            $orderPending = $user->orderWithPaymentPending()->count();
            if($orderPending > 0) {
                return redirect()->back()->with(['msg_error' => 'Maaf tidak bisa checkout. Mohon lunasi pembayaran pending sebelumnya terlebih dahulu!']);
            }
        }
        return $next($request);
    }
}
