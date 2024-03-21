<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (env('APP_ENV') == 'production' && !$request->secure()) {
            redirect()->route(env('APP_URL') . $request->getRequestUri());
        } else {
            return $next($request);
        }
    }
}
