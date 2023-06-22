<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request                                                                          $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('user')) {
            info('if...');
            return $next($request);
        } else {
            info('else');
            session()->pull('user');
            return redirect()->route('login')->with('fail', 'Please Log In');
        }
    }
}
