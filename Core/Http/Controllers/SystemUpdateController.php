<?php

namespace Core\Http\Controllers;

use Core\Models\User;
use Core\Models\Plugin;
use Core\Models\Themes;
use Illuminate\Http\Request;
use Core\Models\PermissionModule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class SystemUpdateController extends Controller
{

    public function __construct()
    {
        if (auth()->user() != null && !auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }
    }

    /**
     * Will redirect to update list
     */
    public function updateList(Request $request)
    {
        $update_available = systemUpdateAvailability();
        $current_version = systemCurrentVersion();
        return view('core::base.update_system.check_update', ['update_available' => $update_available, 'current_version' => $current_version, 'latest_version' => systemLatestVersion()]);
    }

    /**
     * Will update system
     */
    public function updateSystem()
    {
        try {
            $this->importUpdatedDatabase();
            $this->createNewPermissions();
            DB::beginTransaction();
            $this->updateSystemVersion(systemLatestVersion());
            $this->updatePluginVersion(systemLatestVersion());
            $this->updateThemeVersion(systemLatestVersion());
            $this->setAdminUserType();
            $this->setProductSeller();

            $keys = \ThemeLooks\SecureLooks\Model\Key::select('id')->get();
            if ($keys->count() < 1) {
                DB::commit();
                toastNotification('success', 'System update Successfully');
                return redirect()->route(config('themelooks.license_verify_route'));
            }
            DB::commit();
            toastNotification('success', 'System update Successfully');
            return to_route('core.check.update');
        } catch (\Exception $th) {
            DB::rollBack();
            toastNotification('error', 'System update failed');
            return to_route('core.check.update');
        }
    }
    /**
     * Will updated plugin versions
     */
    public function updatePluginVersion($updated_version)
    {
        try {
            DB::beginTransaction();
            Plugin::whereNot('location', 'multivendor')->update(
                [
                    'version' => $updated_version
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
    public function updateThemeVersion($updated_version)
    {
        try {
            DB::beginTransaction();
            Themes::query()->update(
                [
                    'version' => $updated_version
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
     * Will updated system version
     * 
     * @param String $updated version
     */
    public function updateSystemVersion($version)
    {
        try {
            DB::beginTransaction();
            $version_setting_id = getGeneralSettingId('system_version');
            $version_data = [
                'settings_id' => $version_setting_id,
                'value' => $version
            ];
            //Delete Exiting value
            DB::table('tl_general_settings_has_values')
                ->where('settings_id', $version_setting_id)
                ->delete();

            //Store new value
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
     * Will set product seller 
     */
    public function setProductSeller()
    {
        //Update Product
        \Plugin\TlcommerceCore\Models\Product::whereNull('supplier')->update(
            [
                'supplier' => getSupperAdminId()
            ]
        );

        //Update order products
        \Plugin\TlcommerceCore\Models\OrderHasProducts::whereNull('seller_id')->update(
            [
                'seller_id' => getSupperAdminId()
            ]
        );
    }

    /**
     * Will set admin user type
     */
    public function setAdminUserType()
    {
        User::whereNull('user_type')->update(
            [
                'user_type' => config('tlecommercecore.user_type.admin')
            ]
        );
    }

    /**
     * Will import new database
     */
    public function importUpdatedDatabase()
    {
        $sql_path = base_path('plugins/tlecommercecore/update/v2.1.1/data.sql');
        DB::unprepared(file_get_contents($sql_path));
    }

    /**
     * Create New Plugin Permission
     */
    private function createNewPermissions()
    {
        try {
            DB::beginTransaction();
            $permission_module = new PermissionModule();
            $permission_module->parent_module = 'Tlcommerce Page Builder';
            $permission_module->module_name = 'Tlcommerce Page Builder';
            $permission_module->module_type = 'plugin';
            $permission_module->location = 'tlcommerce-pagebuilder';
            $permission_module->order = '4';
            $permission_module->save();
            $latest_permission_id = Permission::latest('id')->first()->id;
            DB::table('permissions')
                ->insert([
                    'id' => ++$latest_permission_id,
                    'guard_name' => 'web',
                    'name' => 'Manage Tlcommerce Page Builder',
                    'module_id' => $permission_module->id,
                ]);
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
}
