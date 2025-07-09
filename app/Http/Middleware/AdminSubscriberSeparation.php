<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminSubscriberSeparation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $user_type)
    {
        if (auth()->guest()) {
            $request->session()->put('url.intended', $request->url());
            if ($user_type == config('saas.user_type.subscriber')) {
                return redirect(getSaasPrefix() . '/login');
            } else {
                return redirect('/admin/login');
            }
        }
        return $next($request);
    }
}
