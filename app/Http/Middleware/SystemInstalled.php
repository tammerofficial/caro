<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SystemInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (env('IS_USER_REGISTERED') == null && env('IS_USER_REGISTERED') == "" && !str_contains($request->url(), 'install')) {
            return redirect()->route('install.welcome');
        }
        return $next($request);
    }
}
