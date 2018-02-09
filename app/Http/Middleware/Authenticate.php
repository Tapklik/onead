<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
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
        $needsToLogIn = (!$request->session()->get('token')) ? true : false;

        if ($needsToLogIn == true && str_contains($request->getUri(), 'auth') != true) {
            return redirect('/admin/auth');
        } else {
            return $next($request);
        }


    }
}
