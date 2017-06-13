<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfAdminAuthenticated
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
        $auth=Auth::guard('web_admin');

        if (!$auth->check()) {

            if (Auth::guard($guard)->check()) {
                return redirect('/home');
            }else{
                return redirect('/admin_login');
            }
            
        }
        return $next($request);
    }
}