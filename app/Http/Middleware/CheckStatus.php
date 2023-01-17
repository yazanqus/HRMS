<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStatus
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
        if (Auth::check() && Auth::user()->status == 'suspended') {
            Auth::logout();
            return redirect(route('login'))->withErrors(['Account is deactivated - Contact HR']);
        }

        else if (Auth::user()->employee_number == NULL) {
            Auth::logout();
            return redirect(route('login'))->withErrors(['Account is deactivated - Contact HR']);
        }
        return $next($request);
    }
}
