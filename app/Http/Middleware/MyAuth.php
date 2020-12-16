<?php

namespace App\Http\Middleware;

use Closure;

class MyAuth
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
        session_start();
        if(!isset($_SESSION['login'])) {
            unset($_SESSION['login']);
            return \redirect('login');
        }
        return $next($request);
    }
}
