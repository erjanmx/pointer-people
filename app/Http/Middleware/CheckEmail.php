<?php

namespace App\Http\Middleware;

use Closure;

class CheckEmail
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
        if (! $request->user()->hasEmail()) {
            return redirect()->route('profile')->with('status', __('Please provide your PointerBP email'));
        }

        return $next($request);
    }
}
