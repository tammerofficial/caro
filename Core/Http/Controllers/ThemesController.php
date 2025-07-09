<?php

namespace Core\Http\Controllers;

use ZipArchive;
use Core\Models\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use AppLoader;

class ThemesController extends Controller
{

    /**
     * Get theme list
     * 
     * @return mixed
     */
    public function index()
    {
        $themes = Themes::all();
        return view('core::base.themes.index', compact('themes'));
    }
    /**
     * Active theme
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function activate(Request $request)
    {
        try {
            DB::beginTransaction();
            $theme = Themes::findOrFail($request->id);
            $theme->is_activated = config('settings.general_status.active');
            $theme->update();

            if (!isTenant() && $theme->type == "saas") {
                DB::table('tl_themes')
                    ->whereNotIn('id', [$request->id])
                    ->where('type', 'saas')
                    ->update([
                        'is_activated' => config('settings.general_status.in_active')
                    ]);
            }

            if (isTenant()) {
                DB::table('tl_themes')
                    ->whereNotIn('id', [$request->id])
                    ->update([
                        'is_activated' => config('settings.general_status.in_active')
                    ]);
            }

            DB::commit();
            $this->resetThemeCache();
            toastNotification('success', translate('Theme activate successfully'), 'Success');
            return redirect()->route('core.themes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Theme activation failed'), 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Redirect to install theme page
     * @return View
     */
    public function create()
    {
        return view('core::base.themes.install');
    }

    /**
     * Install and update theme
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
                toastNotification('success', 'Theme installation failed', 'Success');
                return redirect()->back();
            }

            if ($status) {
                $file_name = $zip->getNameIndex(0);
                $json = $zip->getFromName($file_name . 'theme.json');

                if ($json) {
                    $json_array = json_decode($json);

                    //replace plugin folder
                    $pluginDestinationPath = base_path("themes");
                    if (!File::exists($pluginDestinationPath)) {
                        File::makeDirectory($pluginDestinationPath, 0777, true);
                    }

                    if ($zip->extractTo($pluginDestinationPath)) {
                        chmod($pluginDestinationPath . '/' . $json_array->location, 0777);
                        $zip->close();

                        //Import Database
                        $db = $pluginDestinationPath . '' . $json_array->location . '/data.sql';

                        if (file_exists($db)) {
                            DB::unprepared(file_get_contents($db));
                        }
                    }


                    DB::beginTransaction();
                    //Store new plugin in database
                    $theme = Themes::firstOrNew(['location' => $json_array->location]);
                    $theme->name = $json_array->name;
                    $theme->location = $json_array->location;
                    $theme->author = $json_array->author;
                    $theme->description = $json_array->description;
                    $theme->version = $json_array->version;
                    $theme->unique_indentifier = Str::random(15);
                    $theme->is_activated = config('settings.general_status.in_active');
                    $theme->namespace = $json_array->namespace;
                    $theme->url = $json_array->url;
                    $theme->type = $json_array->type;
                    $theme->save();
                    DB::commit();
                    //reset Cache
                    $this->resetThemeCache();
                    toastNotification('success', 'Theme install successfully', 'Success');
                    return redirect()->route('core.themes.index');
                } else {
                    DB::rollBack();
                    toastNotification('error', 'Theme installation failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            toastNotification('error', 'Theme installation failed', 'Failed');
            return redirect()->back();
        } catch (\Error $e) {
            DB::rollBack();
            toastNotification('error', 'Theme installation failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Verify Purchase Code
     */
    public function verify(Request $request)
    {
        try {

            $plugin = Themes::where('location', $request['theme-location'])->first();
            $res = AppLoader::createApp($request['purchase_key'], false, $request['license_api'], $request['theme-location']);

            if ($plugin && $res == 'SUCCESS') {
                toastNotification('success', translate('Purchase Key Verified Successfully'), 'Success');
                return redirect()->route('core.themes.index');
            }

            return $res;
        } catch (\Exception $e) {
            toastNotification('error', translate('Purchase Key Verifying Failed'), 'Failed');
            return redirect()->route('core.themes.index');
        }
    }

    /**
     * Theme Delete
     */
    public function delete(Themes $theme)
    {
        try {
            if ($theme) {
                if ($theme->is_activated == config('settings.general_status.active')) {
                    toastNotification('error', translate('Active Theme Cannot Be Deleted'), 'Failed');
                    return redirect()->route('core.themes.index');
                }

                if ($theme->location == 'default') {
                    toastNotification('error', translate('Default Theme Cannot Be Deleted'), 'Failed');
                    return redirect()->route('core.themes.index');
                }

                DB::beginTransaction();
                $location = $theme->location;
                $theme->delete();
                DB::commit();

                File::deleteDirectory(base_path('themes/' . $location));
                $this->resetThemeCache();
                toastNotification('success', translate('Theme Deleted Successfully'), 'Successful');
            } else {
                toastNotification('error', translate('Theme Deleting Failed'), 'Failed');
            }

            return redirect()->route('core.themes.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toastNotification('error', translate('Theme Deleting Failed'), 'Failed');
            return redirect()->route('core.themes.index');
        }
    }

    /**
     * Will reset theme cache
     * 
     * @return void
     */
    public function resetThemeCache()
    {
        cache()->forget('active-themes');
    }
}
