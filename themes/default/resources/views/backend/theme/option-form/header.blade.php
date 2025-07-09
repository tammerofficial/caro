{{-- Header Option Header --}}
<h3 class="black mb-3">{{ translate('Header') }}</h3>
<input type="hidden" name="option_name" value="header">

{{-- Header Background Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4">
        <label class="font-16 bold black">{{ translate('Header Background Color') }}
        </label>
        <span class="d-block">{{ translate('Set Header Background Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color">
                <input type="text" class="form-control" name="header_bg_color"
                    value="{{ isset($option_settings['header_bg_color']) ? $option_settings['header_bg_color'] : '' }}">

                <input type="color" class="" id="header_bg_color"
                    value="{{ isset($option_settings['header_bg_color']) ? $option_settings['header_bg_color'] : '#fafafa' }}">

                <label for="header_bg_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="header_bg_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['header_bg_color_transparent']) && $option_settings['header_bg_color_transparent'] == 1 ? 'checked' : '' }}
                        name="header_bg_color_transparent" id="header_bg_color_transparent" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16" for="header_bg_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Header Background Color Field End --}}

{{-- Header Text Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4">
        <label class="font-16 bold black">{{ translate('Header Text Color') }}
        </label>
        <span class="d-block">{{ translate('Set Header Text Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color">
                <input type="text" class="form-control" name="header_text_color"
                    value="{{ isset($option_settings['header_text_color']) ? $option_settings['header_text_color'] : '' }}">

                <input type="color" class="" id="header_text_color"
                    value="{{ isset($option_settings['header_text_color']) ? $option_settings['header_text_color'] : '#fafafa' }}">

                <label for="header_text_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="header_text_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['header_text_color_transparent']) && $option_settings['header_text_color_transparent'] == 1 ? 'checked' : '' }}
                        name="header_text_color_transparent" id="header_text_color_transparent" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16" for="header_text_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Header Text Color Field End --}}

{{-- Sticky Header Text Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4">
        <label class="font-16 bold black">{{ translate('Sticky Header Text Color') }}
        </label>
        <span class="d-block">{{ translate('Set Sticky Header Text Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color">
                <input type="text" class="form-control" name="header_sticky_text_color"
                    value="{{ isset($option_settings['header_sticky_text_color']) ? $option_settings['header_sticky_text_color'] : '' }}">

                <input type="color" class="" id="header_sticky_text_color"
                    value="{{ isset($option_settings['header_sticky_text_color']) ? $option_settings['header_sticky_text_color'] : '#fafafa' }}">

                <label for="header_sticky_text_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="header_sticky_text_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['header_sticky_text_color_transparent']) && $option_settings['header_sticky_text_color_transparent'] == 1 ? 'checked' : '' }}
                        name="header_sticky_text_color_transparent" id="header_sticky_text_color_transparent" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16" for="header_sticky_text_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{--Sticky Header Text Color Field End --}}

{{-- Sticky Header Background Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4">
        <label class="font-16 bold black">{{ translate('Sticky Header Header Background Color') }}
        </label>
        <span class="d-block">{{ translate('Set Sticky Header Header Background color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color">
                <input type="text" class="form-control" name="sticky_header_bg_color"
                    value="{{ isset($option_settings['sticky_header_bg_color']) ? $option_settings['sticky_header_bg_color'] : '' }}">

                <input type="color" class="" id="sticky_header_bg_color"
                    value="{{ isset($option_settings['sticky_header_bg_color']) ? $option_settings['sticky_header_bg_color'] : '#fafafa' }}">

                <label for="sticky_header_bg_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="sticky_header_bg_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['sticky_header_bg_color_transparent']) && $option_settings['sticky_header_bg_color_transparent'] == 1 ? 'checked' : '' }}
                        name="sticky_header_bg_color_transparent" id="sticky_header_bg_color_transparent"
                        value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="sticky_header_bg_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Sticky Header Background Color Field End --}}

{{-- Registration button text --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="registratiion_button_text" class="font-16 bold black">{{ translate('Registration button text') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <input type="text" class="form-control" name="registratiion_button_text" id="registratiion_button_text"
            value="{{ isset($option_settings['registratiion_button_text']) ? $option_settings['registratiion_button_text'] : '' }}">
    </div>
</div>
{{-- Registration button text --}}

{{-- Login button text --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="login_button_text" class="font-16 bold black">{{ translate('Login button text') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <input type="text" class="form-control" name="login_button_text" id="login_button_text"
            value="{{ isset($option_settings['login_button_text']) ? $option_settings['login_button_text'] : '' }}">
    </div>
</div>
{{-- Login button text --}}

{{-- Dashboard button text --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label for="dash_button_text" class="font-16 bold black">{{ translate('Dashboard button text') }}
        </label>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <input type="text" class="form-control" name="dash_button_text" id="dash_button_text"
            value="{{ isset($option_settings['dash_button_text']) ? $option_settings['dash_button_text'] : '' }}">
    </div>
</div>
{{-- Dashboard button text --}}

{{-- Language Option Switch Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3 mb-3">
        <label class="font-16 bold black">{{ translate('Enable language option') }}
        </label>
        <span class="d-block">{{ translate('Switch on for enabling language option.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="language_option" value="0">
            <input type="checkbox"
                {{ isset($option_settings['language_option']) && $option_settings['language_option'] == 1 ? 'checked' : '' }}
                name="language_option" id="language_option" value="1">
            <span class="control" id="language_option_switch">
                <span class="switch-off">Disable</span>
                <span class="switch-on">Enable</span>
            </span>
        </label>
    </div>
</div>
{{-- Language Option Switch End --}}

{{-- Header Registration Background Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Header Registration Button Background Color') }}
        </label>
        <span class="d-block">{{ translate('Set Header Registration Button Background Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="header_reg_bg_color"
                    value="{{ isset($option_settings['header_reg_bg_color']) ? $option_settings['header_reg_bg_color'] : '' }}">

                <input type="color" class="" id="header_reg_bg_color"
                    value="{{ isset($option_settings['header_reg_bg_color']) ? $option_settings['header_reg_bg_color'] : '#fafafa' }}">

                <label for="header_reg_bg_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="header_reg_bg_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['header_reg_bg_color_transparent']) && $option_settings['header_reg_bg_color_transparent'] == 1 ? 'checked' : '' }}
                        name="header_reg_bg_color_transparent" id="header_reg_bg_color_transparent" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="header_reg_bg_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Header Registration Background Color Field End --}}

{{-- Header Registration Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Header Registration Button Color') }}
        </label>
        <span class="d-block">{{ translate('Set Header Registration Button Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="header_reg_color"
                    value="{{ isset($option_settings['header_reg_color']) ? $option_settings['header_reg_color'] : '' }}">

                <input type="color" class="" id="header_reg_color"
                    value="{{ isset($option_settings['header_reg_color']) ? $option_settings['header_reg_color'] : '#fafafa' }}">

                <label for="header_reg_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="header_reg_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['header_reg_color_transparent']) && $option_settings['header_reg_color_transparent'] == 1 ? 'checked' : '' }}
                        name="header_reg_color_transparent" id="header_reg_color_transparent" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="header_reg_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Header Registration Color Field End --}}

{{-- Sticky Header Registration Background Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Sticky Header And Mobile Header  Registration Button Background Color') }}
        </label>
        <span class="d-block">{{ translate('Set Sticky Header And Mobile Header  Registration Button Background Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="sticky_header_reg_bg_color"
                    value="{{ isset($option_settings['sticky_header_reg_bg_color']) ? $option_settings['sticky_header_reg_bg_color'] : '' }}">

                <input type="color" class="" id="sticky_header_reg_bg_color"
                    value="{{ isset($option_settings['sticky_header_reg_bg_color']) ? $option_settings['sticky_header_reg_bg_color'] : '#fafafa' }}">

                <label for="sticky_header_reg_bg_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="sticky_header_reg_bg_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['sticky_header_reg_bg_color_transparent']) && $option_settings['sticky_header_reg_bg_color_transparent'] == 1 ? 'checked' : '' }}
                        name="sticky_header_reg_bg_color_transparent" id="sticky_header_reg_bg_color_transparent"
                        value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="sticky_header_reg_bg_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Sticky Header Registration Background Color Field End --}}

{{-- Sticky Header Registration Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Sticky Header And Mobile Header  Registration Button Color') }}
        </label>
        <span class="d-block">{{ translate('Set Sticky Header And Mobile Header  Registration Button Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="sticky_header_reg_color"
                    value="{{ isset($option_settings['sticky_header_reg_color']) ? $option_settings['sticky_header_reg_color'] : '' }}">

                <input type="color" class="" id="sticky_header_reg_color"
                    value="{{ isset($option_settings['sticky_header_reg_color']) ? $option_settings['sticky_header_reg_color'] : '#fafafa' }}">

                <label for="sticky_header_reg_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="sticky_header_reg_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['sticky_header_reg_color_transparent']) && $option_settings['sticky_header_reg_color_transparent'] == 1 ? 'checked' : '' }}
                        name="sticky_header_reg_color_transparent" id="sticky_header_reg_color_transparent"
                        value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="sticky_header_reg_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Sticky Header Registration Color Field End --}}

{{-- Header Login Background Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Header Login Button Background Color') }}
        </label>
        <span class="d-block">{{ translate('Set Header Login Button Background Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="header_login_bg_color"
                    value="{{ isset($option_settings['header_login_bg_color']) ? $option_settings['header_login_bg_color'] : '' }}">

                <input type="color" class="" id="header_login_bg_color"
                    value="{{ isset($option_settings['header_login_bg_color']) ? $option_settings['header_login_bg_color'] : '#fafafa' }}">

                <label for="header_login_bg_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="header_login_bg_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['header_login_bg_color_transparent']) && $option_settings['header_login_bg_color_transparent'] == 1 ? 'checked' : '' }}
                        name="header_login_bg_color_transparent" id="header_login_bg_color_transparent"
                        value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="header_login_bg_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Header Login Background Color Field End --}}

{{-- Header Login Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Header Login Button Color') }}
        </label>
        <span class="d-block">{{ translate('Set Header Login Button Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="header_login_color"
                    value="{{ isset($option_settings['header_login_color']) ? $option_settings['header_login_color'] : '' }}">

                <input type="color" class="" id="header_login_color"
                    value="{{ isset($option_settings['header_login_color']) ? $option_settings['header_login_color'] : '#fafafa' }}">

                <label for="header_login_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="header_login_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['header_login_color_transparent']) && $option_settings['header_login_color_transparent'] == 1 ? 'checked' : '' }}
                        name="header_login_color_transparent" id="header_login_color_transparent" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="header_login_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Header Login Color Field End --}}

{{-- Sticky Header Login Background Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Sticky Header And Mobile Header  Login Button Background Color') }}
        </label>
        <span class="d-block">{{ translate('Set Sticky Header And Mobile Header  Login Button Background Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="sticky_header_login_bg_color"
                    value="{{ isset($option_settings['sticky_header_login_bg_color']) ? $option_settings['sticky_header_login_bg_color'] : '' }}">

                <input type="color" class="" id="sticky_header_login_bg_color"
                    value="{{ isset($option_settings['sticky_header_login_bg_color']) ? $option_settings['sticky_header_login_bg_color'] : '#fafafa' }}">

                <label for="sticky_header_login_bg_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="sticky_header_login_bg_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['sticky_header_login_bg_color_transparent']) && $option_settings['sticky_header_login_bg_color_transparent'] == 1 ? 'checked' : '' }}
                        name="sticky_header_login_bg_color_transparent" id="sticky_header_login_bg_color_transparent"
                        value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="sticky_header_login_bg_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Sticky Header Login Background Color Field End --}}

{{-- Sticky Header Login Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Sticky Header And Mobile Header  Login Button Color') }}
        </label>
        <span class="d-block">{{ translate('Set Sticky Header And Mobile Header  Login Button Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="sticky_header_login_color"
                    value="{{ isset($option_settings['sticky_header_login_color']) ? $option_settings['sticky_header_login_color'] : '' }}">

                <input type="color" class="" id="sticky_header_login_color"
                    value="{{ isset($option_settings['sticky_header_login_color']) ? $option_settings['sticky_header_login_color'] : '#fafafa' }}">

                <label for="sticky_header_login_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="sticky_header_login_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['sticky_header_login_color_transparent']) && $option_settings['sticky_header_login_color_transparent'] == 1 ? 'checked' : '' }}
                        name="sticky_header_login_color_transparent" id="sticky_header_login_color_transparent"
                        value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="sticky_header_login_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Sticky Header Login Color Field End --}}


{{-- Header Dashboard Background Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Header Dashboard Button Background Color') }}
        </label>
        <span class="d-block">{{ translate('Set Header Dashboard Button Background Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="header_dash_bg_color"
                    value="{{ isset($option_settings['header_dash_bg_color']) ? $option_settings['header_dash_bg_color'] : '' }}">

                <input type="color" class="" id="header_dash_bg_color"
                    value="{{ isset($option_settings['header_dash_bg_color']) ? $option_settings['header_dash_bg_color'] : '#fafafa' }}">

                <label for="header_dash_bg_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="header_dash_bg_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['header_dash_bg_color_transparent']) && $option_settings['header_dash_bg_color_transparent'] == 1 ? 'checked' : '' }}
                        name="header_dash_bg_color_transparent" id="header_dash_bg_color_transparent"
                        value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="header_dash_bg_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Header Dashboard Background Color Field End --}}

{{-- Header Dashboard Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Header Dashboard Button Color') }}
        </label>
        <span class="d-block">{{ translate('Set Header Dashboard Button Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="header_dash_color"
                    value="{{ isset($option_settings['header_dash_color']) ? $option_settings['header_dash_color'] : '' }}">

                <input type="color" class="" id="header_dash_color"
                    value="{{ isset($option_settings['header_dash_color']) ? $option_settings['header_dash_color'] : '#fafafa' }}">

                <label for="header_dash_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="header_dash_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['header_dash_color_transparent']) && $option_settings['header_dash_color_transparent'] == 1 ? 'checked' : '' }}
                        name="header_dash_color_transparent" id="header_dash_color_transparent" value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="header_dash_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Header Dashboard Color Field End --}}

{{-- Sticky Header Dashboard Background Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Sticky Header And Mobile Header  Dashboard Button Background Color') }}
        </label>
        <span class="d-block">{{ translate('Set Sticky Header And Mobile Header Dashboard Button Background Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="sticky_header_dash_bg_color"
                    value="{{ isset($option_settings['sticky_header_dash_bg_color']) ? $option_settings['sticky_header_dash_bg_color'] : '' }}">

                <input type="color" class="" id="sticky_header_dash_bg_color"
                    value="{{ isset($option_settings['sticky_header_dash_bg_color']) ? $option_settings['sticky_header_dash_bg_color'] : '#fafafa' }}">

                <label for="sticky_header_dash_bg_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="sticky_header_dash_bg_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['sticky_header_dash_bg_color_transparent']) && $option_settings['sticky_header_dash_bg_color_transparent'] == 1 ? 'checked' : '' }}
                        name="sticky_header_dash_bg_color_transparent" id="sticky_header_dash_bg_color_transparent"
                        value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="sticky_header_dash_bg_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Sticky Header Dashboard Background Color Field End --}}

{{-- Sticky Header Dashboard Color Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4 mb-3">
        <label class="font-16 bold black">{{ translate('Sticky Header And Mobile Header Dashboard Button Color') }}
        </label>
        <span class="d-block">{{ translate('Set Sticky Header And Mobile Header  Dashboard Button Color.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <div class="row ml-2">
            <div class="color justify-content-between">
                <input type="text" class="form-control" name="sticky_header_dash_color"
                    value="{{ isset($option_settings['sticky_header_dash_color']) ? $option_settings['sticky_header_dash_color'] : '' }}">

                <input type="color" class="" id="sticky_header_dash_color"
                    value="{{ isset($option_settings['sticky_header_dash_color']) ? $option_settings['sticky_header_dash_color'] : '#fafafa' }}">

                <label for="sticky_header_dash_color">{{ translate('Select Color') }}</label>
            </div>
            <div class="d-flex align-items-center">
                <label class="custom-checkbox position-relative ml-2 mr-1">
                    <input type="hidden" name="sticky_header_dash_color_transparent" value="0">
                    <input type="checkbox"
                        {{ isset($option_settings['sticky_header_dash_color_transparent']) && $option_settings['sticky_header_dash_color_transparent'] == 1 ? 'checked' : '' }}
                        name="sticky_header_dash_color_transparent" id="sticky_header_dash_color_transparent"
                        value="1">
                    <span class="checkmark"></span>
                </label>
                <label class="black font-16"
                    for="sticky_header_dash_color_transparent">{{ translate('Transparent') }}</label>
            </div>
        </div>
    </div>
</div>
{{-- Sticky Header Dashboard Color Field End --}}
