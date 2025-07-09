<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class SystemHelper
{
    /** 
     * Check tenant
     */
    public static function isTenant()
    {
        $request = app('request');
        $current_domain = clean_domain($request->getHost());
        if (!in_array($current_domain, config('tenancy.central_domains'))) {
            $tenant_id = tenancy()->central(function () {
                $request = app('request');
                $current_domain = xss_clean($request->getHost());
                $domain = DB::table('domains')->where('domain', '=', $current_domain)->first();
                if ($domain != null) {
                    return $domain->tenant_id;
                }
                return false;
            });
            return $tenant_id;
        }

        return false;
    }

    /**
     * get admin dashboard prefix
     *
     * @return string
     */
    public static function getAdminPrefix()
    {
        return 'admin';
    }
}
