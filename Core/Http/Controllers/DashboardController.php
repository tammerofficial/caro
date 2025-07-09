<?php

namespace Core\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        if (!isTenant()) {
            $this->middleware(['license', 'is-saas']);
        }
    }

    public function dashboard()
    {
        if (!isTenant()) {
            $update_config_path = base_path('updates/config.json');

            $config_file = @file_get_contents($update_config_path, true);
            if ($config_file === true) {
                $json = json_decode($config_file, true);
                $system_version = getGeneralSetting('system_version');
                if ($system_version == $json['version']) {
                    return view('core::base.dashboard.index');
                }
            }


            if (file_exists($update_config_path)) {
                return view('core::base.system.update.update_dashboard');
            }
        }
        return view('core::base.dashboard.index');
    }
}
