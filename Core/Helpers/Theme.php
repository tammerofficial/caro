<?php

use Core\Models\Themes;
use Core\Models\Language;
use Illuminate\Support\Facades\Cache;
// use Session;

if (!function_exists('getActiveThemeOptions')) {
    /**
     * get active theme's theme options
     *
     * @return String
     */
    function getActiveThemeOptions()
    {
        $theme = getActiveTheme();
        $item = 'theme/' . $theme->location . '::backend.includes.themeOptions';
        return $item;
    }
}

if (!function_exists('defaultLanguage')) {
    /**
     * get system default language
     *
     * @return Collection
     */
    function defaultLanguage()
    {
        $default_language_id = getGeneralSetting('default_language');
        if ($default_language_id != null) {
            $lang_details = Language::where('id', $default_language_id)->select('id', 'code')->first();
            if ($lang_details != null) {
                return $lang_details->code;
            } else {
                return 'en';
            }
        } else {
            return 'en';
        }
    }
}


if (!function_exists('getActiveTheme')) {
    /**
     * get active theme
     *
     * @return Collection
     */
    function getActiveTheme($for_collection = false)
    {
        if (isTenant()) {
            $themes = Cache::remember(isTenant() . "-active-themes", 100 * 60, function () {
                currentTenantDatabaseConnection();
                return Themes::on('tenant')->get();
            });
        }

        if (!isTenant()) {
            $themes = Cache::remember("active-themes", 100 * 60, function () {
                return Themes::where('type', 'saas')->get();
            });
        }

        if ($for_collection) {
            return $themes->where('is_activated', config('settings.general_status.active'));
        } else {
            return $themes->where('is_activated', config('settings.general_status.active'))->first();
        }
    }
}
