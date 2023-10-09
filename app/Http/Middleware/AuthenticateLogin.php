<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $employee = session()->get('employee');
        if ($employee) {
            return $next($request);
        }
        return redirect()->route('login');
    }
}
