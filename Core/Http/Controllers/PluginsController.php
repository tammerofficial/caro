<?php

namespace Core\Http\Controllers;

use AppLoader;
use ZipArchive;
use Core\Models\Plugin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Jobs\UpdateTenantDatabaseJob;
use Illuminate\Support\Facades\Cache;

class PluginsController extends Controller
{
    /**
     * Get plugins list
     *
     * @return mixed
     */
    public function index()
    {
        if (isTenant()) {
            $plugins = Plugin::select(['location', 'is_activated', 'id'])
                ->get()
                ->map(function ($plugin) {
                    $plugin_info = file_get_contents(base_path("plugins/{$plugin->location}/plugin.json"));
                    $data = json_decode($plugin_info, true);
                    return [...$plugin->toArray(), ...$data];
                });
        } else {
            $plugins = Plugin::select(['location', 'is_activated', 'id', 'type'])
                ->orderBy('type', 'desc')
                ->get()
                ->map(function ($plugin) {
                    $plugin_info = file_get_contents(base_path("plugins/{$plugin->location}/plugin.json"));
                    $data = json_decode($plugin_info, true);
                    return [...$plugin->toArray(), ...$data];
                });
        }



        return view('core::base.plugins.index', compact('plugins'));
    }
    /**
     * Redirect to install plugin page
     *
     * @return mixed
     */
    public function create()
    {
        return view('core::base.plugins.install');
    }

    /**
     * Deactivate plugin
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function inactive(Request $request)
    {
        try {
            DB::beginTransaction();
            $plugin = Plugin::findOrFail($request->id);
            $plugin->is_activated = config('settings.general_status.in_active');
            $plugin->update();
            DB::commit();
            $this->resetPluginsCache();
            toastNotification('success', translate('Plugin inactive successfully'), 'Success');
            return redirect()->route('core.plugins.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Plugin deactivation failed'), 'Failed');
            return redirect()->route('core.plugins.index');
        }
    }
    /**
     * Activate plugin
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function activate(Request $request)
    {
        try {
            DB::beginTransaction();
            $plugin = Plugin::findOrFail($request->id);
            $plugin->is_activated = config('settings.general_status.active');
            $plugin->update();
            DB::commit();
            $this->resetPluginsCache();
            toastNotification('success', translate('Plugin activate successfully'), 'Success');
            return redirect()->route('core.plugins.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Plugin activation failed'), 'Failed');
            return redirect()->route('core.plugins.index');
        }
    }

    /**
     * Install and update plugin
     *
     * @param Request $request
     * @return mixed
     */
    public function install(Request $request)
    {
        try {
            $zip = new ZipArchive();
            $status = $zip->open($request->file("zip_file")->getRealPath());
            if ($status != true) {
                toastNotification('success', 'Plugin installation failed', 'Success');
                return redirect()->back();
            }

            if ($status) {
                $file_name = $zip->getNameIndex(0);
                $json = $zip->getFromName($file_name . 'plugin.json');

                if ($json) {
                    $json_array = json_decode($json);

                    //replace plugin folder
                    $pluginDestinationPath = base_path("plugins/");
                    if (!File::exists($pluginDestinationPath)) {
                        File::makeDirectory($pluginDestinationPath, 0777, true);
                    }

                    if ($zip->extractTo($pluginDestinationPath)) {
                        chmod($pluginDestinationPath . '/' . $json_array->location, 0777);
                        $zip->close();

                        //Import Database
                        $db = $pluginDestinationPath . '' . $json_array->location . '/data.sql';

                        if (file_exists($db)) {
                            $sql = file_get_contents($db);

                            if ($json_array->type == 'saas') {
                                DB::unprepared(file_get_contents($db));
                            } elseif ($json_array->type == 'tenant') {
                                DB::table('tl_saas_accounts')
                                    ->where('is_db_created', '=', 1)
                                    ->update([
                                        'is_plugin_db_updated' => 0,
                                        'status' => 0,
                                    ]);

                                $all_tenants = DB::table('tl_saas_accounts')
                                    ->where('is_db_created', '=', 1)
                                    ->pluck('tenant_id');

                                for ($i = 0; $i < sizeof($all_tenants); $i++) {
                                    $job = new UpdateTenantDatabaseJob($all_tenants[$i], $sql, true, $json_array->location);
                                    dispatch($job);
                                }
                            }
                        }
                    }


                    DB::beginTransaction();
                    //Store new plugin in database
                    $plugin = Plugin::firstOrNew(['name' => $json_array->name]);
                    $plugin->name = $json_array->name;
                    $plugin->location = $json_array->location;
                    $plugin->author = $json_array->author;
                    $plugin->description = $json_array->description;
                    $plugin->version = $json_array->version;
                    $plugin->unique_indentifier = Str::random(15);
                    $plugin->is_activated = config('settings.general_status.active');
                    $plugin->namespace = $json_array->namespace;
                    $plugin->url = $json_array->url;
                    $plugin->type = $json_array->type == 'saas' ? 'saas' : 'tlcommerce';
                    $plugin->save();
                    DB::commit();
                    //reset Cache
                    $this->resetPluginsCache();
                    toastNotification('success', 'Plugin install successfully. Please activate plugin', 'Success');
                    return redirect()->route('core.plugins.index');
                } else {
                    DB::rollBack();
                    toastNotification('error', 'Plugin installation failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', 'Plugin installation failed', 'Failed');
            return redirect()->back();
        } catch (\Error $e) {
            DB::rollBack();
            toastNotification('error', 'Plugin installation failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Verify Purchase Code
     */
    public function verify(Request $request)
    {
        try {

            $plugin = Plugin::where('location', $request['plugin-location'])->first();
            $res = AppLoader::createApp($request['purchase_key'], false, $request['license_api'], $request['plugin-location']);

            if ($plugin && $res == 'SUCCESS') {
                toastNotification('success', translate('Purchase Key Verified Successfully'), 'Success');
                return redirect()->route('core.plugins.index');
            }

            return $res;
        } catch (\Exception $e) {
            toastNotification('error', translate('Purchase Key Verifying Failed'), 'Failed');
            return redirect()->route('core.plugins.index');
        }
    }

    /**
     * Will reset plugin cache
     *
     * @return void
     */
    public function resetPluginsCache()
    {
        cache()->forget('active-plugins');
    }

    /**
     * Plugin Delete
     */
    public function delete(Plugin $plugin)
    {
        try {
            if ($plugin) {
                DB::beginTransaction();
                $location = $plugin->location;
                $plugin->delete();
                DB::commit();

                if (file_exists(base_path('plugins/' . $location . '/delete.sql'))) {
                    DB::unprepared(file_get_contents(base_path('plugins/' . $location . '/delete.sql')));
                }

                File::deleteDirectory(base_path('plugins/' . $location));
                $this->resetPluginsCache();
                toastNotification('success', translate('Plugin Deleted Successfully'), 'Successful');
            } else {
                toastNotification('error', translate('Plugin Deleting Failed'), 'Failed');
            }

            return redirect()->route('core.plugins.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Plugin Deleting Failed'), 'Failed');
            return redirect()->route('core.plugins.index');
        }
    }
}
