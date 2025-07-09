<h3 class="black mb-3">{{ translate('Site Mood') }}</h3>
<input type="hidden" name="option_name" value="dark_light_switcher">

<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Enable Dark/ Light Switcher') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="dark_light_status" value="0">
            <input type="checkbox"
                {{ isset($option_settings['dark_light_status']) && $option_settings['dark_light_status'] == 1 ? 'checked' : '' }}
                name="dark_light_status" id="dark_light_status" value="1">
            <span class="control" id="dark_light_status_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="topbar_banner_link" class="font-16 bold black">{{ translate('Default Mood') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <select name="site_default_screen_mood" class="form-control select" id="site_default_screen_mood">
            <option value="light" @selected(isset($option_settings['site_default_screen_mood']) && $option_settings['site_default_screen_mood'] == 'light')>
                {{ translate('Light') }}
            </option>
            <option value="dark" @selected(isset($option_settings['site_default_screen_mood']) && $option_settings['site_default_screen_mood'] == 'dark')>
                {{ translate('Dark') }}
            </option>
        </select>
    </div>
</div>
<h3 class="black mb-3">{{ translate('Site Mood') }}</h3>
<input type="hidden" name="option_name" value="dark_light_switcher">

<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Enable Dark/ Light Switcher') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="dark_light_status" value="0">
            <input type="checkbox"
                {{ isset($option_settings['dark_light_status']) && $option_settings['dark_light_status'] == 1 ? 'checked' : '' }}
                name="dark_light_status" id="dark_light_status" value="1">
            <span class="control" id="dark_light_status_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="topbar_banner_link" class="font-16 bold black">{{ translate('Default Mood') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <select name="site_default_screen_mood" class="form-control select" id="site_default_screen_mood">
            <option value="light" @selected(isset($option_settings['site_default_screen_mood']) && $option_settings['site_default_screen_mood'] == 'light')>
                {{ translate('Light') }}
            </option>
            <option value="dark" @selected(isset($option_settings['site_default_screen_mood']) && $option_settings['site_default_screen_mood'] == 'dark')>
                {{ translate('Dark') }}
            </option>
        </select>
    </div>
</div>
