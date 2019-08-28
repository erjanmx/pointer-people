<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $allowedIps = config('auth.allowed_ips', ['*']);

        if ($allowedIps !== ['*'] && !in_array($request->ip(), $allowedIps)) {
            return response()->json(['This application is accessible from Pointer office network only']);
        }

        return $next($request);
    }
}
