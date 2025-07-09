<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckSubscriberAuthentication
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
        if (isTenant()) {
            $store_status = tenancy()->central(function () {
                $now = now();
                $request = app('request');
                $current_domain = clean_domain($request->getHost());
                $domain = DB::table('domains')->where('domain', '=', $current_domain)->first();
                $is_active = DB::table('tl_saas_accounts')
                    ->where('tenant_id', '=', $domain->tenant_id)
                    ->where('status', '=', config('settings.user_status.active'))
                    ->exists();

                $is_valid = DB::table('tl_saas_accounts')
                    ->where('tenant_id', '=', $domain->tenant_id)
                    ->where('valid_till', '>=', $now)
                    ->exists();

                $is_lifetime = DB::table('tl_saas_accounts')
                    ->where('tenant_id', '=', $domain->tenant_id)
                    ->whereNull('valid_till')
                    ->exists();

                return ($is_active && ($is_valid || $is_lifetime));
            });

            if (!$store_status) {
                abort(401);
            }
        }


        return $next($request);
    }
}
