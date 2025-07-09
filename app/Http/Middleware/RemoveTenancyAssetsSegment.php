<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RemoveTenancyAssetsSegment
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
        $response = $next($request);

        // Modify the response content to remove "tenancy/assets" segment from the URLs
        if ($response instanceof \Illuminate\Http\Response) {
            $content = $response->getContent();
            $content = str_replace('/tenancy/assets/', '/', $content);
            $response->setContent($content);
        }

        if (env('IS_USER_REGISTERED') == 1 && !isTenant()) {
            $this->removeUpdateFolder();
        }

        return $response;
    }

    /**
     * Remove update folder
     */
    public function removeUpdateFolder()
    {
        $saas_account = DB::table('tl_saas_accounts')
            ->where('is_system_db_updated', '=', 0)
            ->exists();

        if (!$saas_account) {

            $update_config_path = base_path('updates/config.json');

            $config_file = @file_get_contents($update_config_path, true);
            if ($config_file === true) {
                $json = json_decode($config_file, true);
                $system_version = getGeneralSetting('system_version');
                if ($system_version == $json['version']) {

                    $update_path = base_path('updates');
                    File::deleteDirectory($update_path);

                    $temp_storage_path = storage_path('app/tempUpdate');
                    File::deleteDirectory($temp_storage_path);
                }
            }
        }
    }
}
