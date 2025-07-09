<?php

namespace Core\Http\Controllers;

use AppLoader;

use Core\Models\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SystemController extends Controller
{
    /**
     * Will clear system  cache
     */
    public function clearSystemCache()
    {
        try {
            cache_clear();
            toastNotification('success', translate('Cache clear successfully'));
            return redirect()->back();
        } catch (\Exception $e) {
            toastNotification('error', translate('Cache clear failed'));
        }
    }

    /**
     * Will clear system  cache
     */
    public function clearSystemCacheFromApi()
    {
        try {
            cache_clear();
            return response()->json(
                [
                    'success' => true,
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }

    public function activateLicense(Request $request)
    {
        $request->validate([
            'license' => 'required'
        ]);

        $res = AppLoader::createApp($request['license'], false);
        if ($res == 'SUCCESS') {
            $this->updateSystemVersion(systemLatestVersion());
            $this->updatePluginVersion(systemLatestVersion(), $request['license']);
            $this->updateThemeVersion(systemLatestVersion(), $request['license']);

            $this->updatePaymentMethods();
            $this->checkIfSystemHasPermissionToCreateDatabase();
            $this->updatePageAuthor();
            $this->setCentralDomain();
            return redirect()->route('admin.dashboard');
        }

        return $res;
    }

    public function storePurchaseKey(Request $request)
    {
        $request->validate([
            'license' => 'required'
        ]);

        return  AppLoader::validateApp($request['license']);
    }

    /**
     * Will update system version
     */

    public function updateSystemVersion($updated_version)
    {
        try {
            DB::beginTransaction();
            $version_setting_id = getGeneralSettingId('system_version');
            $version_data = [
                'settings_id' => $version_setting_id,
                'value' => $updated_version
            ];
            //Delete Exiting Version
            DB::table('tl_general_settings_has_values')
                ->where('settings_id', $version_setting_id)
                ->delete();

            //Store new Version
            DB::table('tl_general_settings_has_values')
                ->where('settings_id', $version_setting_id)
                ->insert($version_data);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        } catch (\Error $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Will updated plugin versions
     */
    public function updatePluginVersion($updated_version, $purchase_key)
    {
        try {
            DB::beginTransaction();
            Plugin::whereNot('location', 'multivendor')->update(
                [
                    'version' => $updated_version,
                    'unique_indentifier' => $purchase_key
                ]
            );
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        } catch (\Error $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Will updated theme versions
     */
    public function updateThemeVersion($updated_version, $purchase_key)
    {
        try {
            DB::beginTransaction();
            Themes::query()->update(
                [
                    'version' => $updated_version,
                    'unique_indentifier' => $purchase_key
                ]
            );

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        } catch (\Error $e) {
            DB::rollBack();
            return false;
        }
    }

    public function updatePaymentMethods()
    {
        try {
            DB::beginTransaction();
            $is_extended_licensed = DB::table('user_keys')->where('type', '=', 'Extended')->exists();

            if ($is_extended_licensed) {
                $sql_path = base_path('database/payment.sql');
                DB::unprepared(file_get_contents($sql_path));
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        } catch (\Error $e) {
            DB::rollBack();
            return false;
        }
    }

    public function checkIfSystemHasPermissionToCreateDatabase()
    {
        try {
            DB::select('CREATE DATABASE laravel_temporary_check');
            DB::statement('DROP DATABASE laravel_temporary_check');
            setEnv('HAS_DB_CREATE_PERMISSION', 1);
        } catch (\Exception $e) {
            setEnv('HAS_DB_CREATE_PERMISSION', 0);
        }
    }

    public function updatePageAuthor()
    {
        try {
            $user = DB::table('tl_users')->first();
            if (!empty($user)) {
                DB::table('tl_pages')->update([
                    'user_id' => 1
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        } catch (\Error $e) {
            DB::rollBack();
            return false;
        }
    }

    public function setCentralDomain()
    {
        $request = app('request');
        $current_domain = $request->getHost();
        setEnv('CENTRAL_DOMAIN', $current_domain);
    }
}
