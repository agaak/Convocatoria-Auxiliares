<?php

namespace App\Http\Middleware;

use Closure;

class RedirectView
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
        if (session()->get('ver') !== null) {
            return $next($request);
        }
        return redirect('/');
    }
}
