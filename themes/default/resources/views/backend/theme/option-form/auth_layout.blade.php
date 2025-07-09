<h3 class="black mb-3">{{ translate('Auth Layout') }}</h3>
<input type="hidden" name="option_name" value="auth_layout">

{{-- Custom User Registration Image Field Start --}}
<div id="custom_user_reg_bg_type_image">
    <div class="form-group row py-3 border-bottom">
        <div class="col-xl-4">
            <label for="user_reg_bg_image" class="font-16 bold black">{{ translate('User Registration BG Image') }}
            </label>
            <span class="d-block">{{ translate('Set User Registration Image.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            @include('core::base.includes.media.media_input', [
                'input' => 'user_reg_bg_image',
                'data' => isset($option_settings['user_reg_bg_image'])
                    ? $option_settings['user_reg_bg_image']
                    : null,
            ])
        </div>
    </div>
</div>
{{-- Custom User Registration Image Field End --}}


{{-- Custom User Login Image Field Start --}}
<div id="custom_user_login_bg_type_image">
    <div class="form-group row py-3 border-bottom">
        <div class="col-xl-4">
            <label for="user_login_bg_image" class="font-16 bold black">{{ translate('User Login BG Image') }}
            </label>
            <span class="d-block">{{ translate('Set User Login Image.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            @include('core::base.includes.media.media_input', [
                'input' => 'user_login_bg_image',
                'data' => isset($option_settings['user_login_bg_image'])
                    ? $option_settings['user_login_bg_image']
                    : null,
            ])
        </div>
    </div>
</div>
{{-- Custom User Login Image Field End --}}