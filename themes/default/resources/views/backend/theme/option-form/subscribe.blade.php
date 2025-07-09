@php
    $pages = getPage([['tl_pages.publish_status', '=', config('default.page_status.publish')], ['tl_pages.publish_at', '<', currentDateTime()]]);
@endphp
{{-- Subscribe Header --}}
<h3 class="black mb-3">{{ translate('Subscribe') }}</h3>
<input type="hidden" name="option_name" value="subscribe">

{{-- Mailchimp API Key Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4">
        <label for="mailchimp_api_key" class="font-16 bold black">{{ translate('Mailchimp API Key') }}
        </label>
        <span class="d-block">{{ translate('Set mailchimp api key') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <input type="text" name="mailchimp_api_key" id="mailchimp_api_key" class="form-control"
            value="{{ isset($option_settings['mailchimp_api_key']) ? $option_settings['mailchimp_api_key'] : '' }}">
    </div>
</div>
{{-- Mailchimp API Key Field End --}}

{{-- Mailchimp List ID Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4">
        <label for="mailchimp_list_id" class="font-16 bold black">{{ translate('Mailchimp List ID') }}
        </label>
        <span class="d-block">{{ translate('Set mailchimp list id.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <input type="text" name="mailchimp_list_id" id="mailchimp_list_id" class="form-control"
            value="{{ isset($option_settings['mailchimp_list_id']) ? $option_settings['mailchimp_list_id'] : '' }}">
    </div>
</div>
{{-- Mailchimp List ID Field End --}}

{{-- Footer Subscribe Form Enable/Disable Field Start --}}
<div class="form-group row py-4 border-bottom">
    <div class="col-xl-4">
        <label class="font-16 bold black">{{ translate('Footer Subscribe Form') }}
        </label>
        <span class="d-block">{{ translate('Set Enable to display Subscribe form in footer.') }}</span>
    </div>
    <div class="col-xl-6 offset-xl-1">
        <label class="switch success">
            <input type="hidden" name="footer_subscribe_form" value="0">
            <input type="checkbox"
                {{ isset($option_settings['footer_subscribe_form']) && $option_settings['footer_subscribe_form'] == 1 ? 'checked' : '' }}
                name="footer_subscribe_form" id="footer_subscribe_form" value="1">
            <span class="control" id="footer_subscribe_form_switch">
                <span class="switch-off">{{ translate('Disable') }}</span>
                <span class="switch-on">{{ translate('Enable') }}</span>
            </span>
        </label>
    </div>
</div>
{{-- Footer Subscribe Form Enable/Disable Field End --}}

{{-- Footer Subscribe Form Enable Field Start --}}
<div id="footer_subscribe_form_switch_on_field">
    {{-- Form Title Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4">
            <label for="subscribe_form_title" class="font-16 bold black">{{ translate('Form Title') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <input type="text" class="form-control" name="subscribe_form_title" id="subscribe_form_title"
                value="{{ isset($option_settings['subscribe_form_title']) ? $option_settings['subscribe_form_title'] : '' }}">
                <small>{{ translate('Transalate to another language') }} <a
                    href="{{ route('core.languages') }}">{{ translate('click here') }}.</a></small>
        </div>
    </div>
    {{-- Form Title Field End --}}

    {{-- Form Placeholder Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4">
            <label for="subscribe_form_placeholder" class="font-16 bold black">{{ translate('Form Placeholder') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <input type="text" class="form-control" name="subscribe_form_placeholder" id="subscribe_form_placeholder"
                value="{{ isset($option_settings['subscribe_form_placeholder']) ? $option_settings['subscribe_form_placeholder'] : '' }}">
                <small>{{ translate('Transalate to another language') }} <a
                    href="{{ route('core.languages') }}">{{ translate('click here') }}.</a></small>
        </div>
    </div>
    {{-- Form Placeholder Field End --}}

    {{-- Form Button Text Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4">
            <label for="subscribe_form_button_text" class="font-16 bold black">{{ translate('Form Button Text') }}
            </label>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <input type="text" class="form-control" name="subscribe_form_button_text" id="subscribe_form_button_text"
                value="{{ isset($option_settings['subscribe_form_button_text']) ? $option_settings['subscribe_form_button_text'] : '' }}">
                <small>{{ translate('Transalate to another language') }} <a
                    href="{{ route('core.languages') }}">{{ translate('click here') }}.</a></small>
        </div>
    </div>
    {{-- Form Button Text Field End --}}

    {{-- Privacy Policy Enable/Disable Field Start --}}
    <div class="form-group row py-4 border-bottom">
        <div class="col-xl-4">
            <label class="font-16 bold black">{{ translate('Privacy Policy') }}
            </label>
            <span class="d-block">{{ translate('Set Enable to display Privacy Policy Button.') }}</span>
        </div>
        <div class="col-xl-6 offset-xl-1">
            <label class="switch success">
                <input type="hidden" name="privacy_policy" value="0">
                <input type="checkbox"
                    {{ isset($option_settings['privacy_policy']) && $option_settings['privacy_policy'] == 1 ? 'checked' : '' }}
                    name="privacy_policy" id="privacy_policy" value="1">
                <span class="control" id="privacy_policy_switch">
                    <span class="switch-off">{{ translate('Disable') }}</span>
                    <span class="switch-on">{{ translate('Enable') }}</span>
                </span>
            </label>
        </div>
    </div>
    {{-- Privacy Policy Enable/Disable Field End --}}

    {{-- Privacy Policy Enable Field Start --}}
    <div id="privacy_policy_switch_on_field">
        {{-- Privacy Policy Page Select Field Start --}}
        <div class="form-group row py-4 border-bottom">
            <div class="col-xl-4">
                <label class="font-16 bold black">{{ translate('Privacy Policy Page') }}
                </label>
                <span class="d-block">{{ translate('Select Privacy Policy Page.') }}</span>
            </div>
            <div class="col-xl-6 offset-xl-1">
                <select class="form-control select" name="privacy_policy_page" id="privacy_policy_page">
                    @foreach ($pages as $item)
                        <option value="{{ $item->id }}"
                            {{ isset($option_settings['privacy_policy_page']) && $option_settings['privacy_policy_page'] == $item->id ? 'selected' : '' }}>
                            {{ $item->translation('title', getLocale()) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{-- Privacy Policy Page Select Field End --}}
    </div>
    {{-- Privacy Policy Enable Field End --}}
</div>
{{-- Footer Subscribe Form Enable Field End --}}
