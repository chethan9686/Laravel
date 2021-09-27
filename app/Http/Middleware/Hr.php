<?php

namespace App\Http\Middleware;

use Closure;

class Hr
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
        if (auth()->user()->user_position == 5) {
            return $next($request);
        }
       return redirect()->route('dashboard');
    }
}
