<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SellerAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() != null && auth()->user()->user_type == config('tlecommercecore.user_type.seller')) {
            return $next($request);
        }
        if (isActivePluging('multivendor')) {
            return redirect('/seller/login');
        }
        return redirect('/');
    }
}
