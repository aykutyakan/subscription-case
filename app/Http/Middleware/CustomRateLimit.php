<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomRateLimit
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
        return $request->reciept % 6 == 0
                        ? abort(500)
                        : $next($request);
    }
}
