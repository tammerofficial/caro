@php
    use Plugin\TlcommerceCore\Repositories\SettingsRepository;
    use Core\Repositories\SettingsRepository as CoreSettingRepository;
    use Illuminate\Support\Facades\Cache;

    $siteProperties = Cache::rememberForever('site-properties', function () {
        return CoreSettingRepository::SiteProperties();
    });

    $site_name = str_replace('"', '', $siteProperties['site_title']);
    $site_name = str_replace("'", '', $site_name);

    $site_moto = $siteProperties['site_motto'] != null ? '|' . $siteProperties['site_motto'] : '';
    $site_title = $site_name . '' . $site_moto;

    $default_language = defaultLanguage();
    $default_curency = SettingsRepository::defaultCurrency();

    $active_theme = getActiveTheme();

    $body_typography = themeOptionToCss('body_typography', $active_theme->id);
    $paragraph_typography = themeOptionToCss('paragraph_typography', $active_theme->id);
    $heading_typography = themeOptionToCss('heading_typography', $active_theme->id);
    $menu_typography = themeOptionToCss('menu_typography', $active_theme->id);
    $button_typography = themeOptionToCss('button_typography', $active_theme->id);
    $logo_details = getGeneralSettingsDetails();
    $custom_js_properties = getThemeOption('custom_js', $active_theme->id);
    $site_mood_setting = getThemeOption('dark_light_switcher', $active_theme->id);
    $site_default_mood =
        isset($site_mood_setting['site_default_screen_mood']) &&
        $site_mood_setting['site_default_screen_mood'] == 'dark'
            ? 'dark'
            : '';
    $tenant_id = getGeneralSetting('tenant_id');

@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    @if (isset($logo_details['favicon']))
        <link rel="shortcut icon" href="{{ project_asset($logo_details['favicon']) }}">
    @else
        <link rel="shortcut icon" href="{{ asset('/public/backend/assets/img/favicon.png') }}">
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('seo')
    <meta property="og:image:width" content="1200" />
    <meta name="brand_name" content="{{ $site_name }}" />
    <link rel="canonical" href="{{ env('APP_URL') }}" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta name="twitter:domain" content="{{ env('APP_URL') }}" />
    <meta property="og:site_name" content="{{ $site_name }}" />
    <meta name="twitter:site" content="{{ $site_name }}" />
    <meta name="apple-mobile-web-app-title" content="{{ $site_title }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/fontawsome/css/all.min.css') }}">
    <link rel="stylesheet" href="/themes/tlcommerce/public/blog/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/themes/tlcommerce/public/css/custom_app.css') }}">


    <link rel="stylesheet" type="text/css"
        href="{{ asset('/themes/tlcommerce/public/css/' . $tenant_id . '/back_to_top.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/themes/tlcommerce/public/css/' . $tenant_id . '/header.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/themes/tlcommerce/public/css/' . $tenant_id . '/header_logo.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/themes/tlcommerce/public/css/' . $tenant_id . '/menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/themes/tlcommerce/public/css/' . $tenant_id . '/blog.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/themes/tlcommerce/public/css/' . $tenant_id . '/sidebar_options.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/themes/tlcommerce/public/css/' . $tenant_id . '/page_404.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/themes/tlcommerce/public/css/' . $tenant_id . '/subscribe.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/themes/tlcommerce/public/css/' . $tenant_id . '/footer.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/themes/tlcommerce/public/css/' . $tenant_id . '/social_icon.css') }}">
    <!-- Including all google fonts link -->
    @includeIf('theme/tlcommerce::frontend.blog.includes.custom.google-font-link', [
        'body_typography' => $body_typography,
        'paragraph_typography' => $paragraph_typography,
        'heading_typography' => $heading_typography,
        'menu_typography' => $menu_typography,
        'button_typography' => $button_typography,
    ])
    <!-- Including all dynamic css -->
    @includeIf('theme/tlcommerce::frontend.blog.includes.custom.tl-dynamic-css', [
        'body_typography' => $body_typography,
        'paragraph_typography' => $paragraph_typography,
        'heading_typography' => $heading_typography,
        'menu_typography' => $menu_typography,
        'button_typography' => $button_typography,
    ])
    <!-- Theme Option Css -->

    {{-- Include Builder Css If Page or Homepage is Build with Builder --}}
    @yield('builder-css-link')
    <!--Custom script-->
    @if ($custom_js_properties != null)
        {!! $custom_js_properties['header_custom_js_code'] !!}
    @endif
    <!--End custom script-->
</head>

<body class="antialiased">
    <div id="app">
    </div>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/themes/tlcommerce/public/css/' . $tenant_id . '/custom_css.css') }}">
    <script>
        //set site title
        let site_title = localStorage.getItem('site_title');
        localStorage.setItem('site_title', '<?php echo $site_title; ?>');

        //set default language
        let locale = localStorage.getItem('locale');
        if (locale == null) {
            localStorage.setItem('locale', '<?php echo $default_language; ?>');
        }
        //set selected currency
        let currency = localStorage.getItem('currency');

        if (currency == null) {
            localStorage.setItem('currency', '<?php echo $default_curency; ?>');
        }
        //set default currency
        localStorage.setItem('default_currency', '<?php echo $default_curency; ?>');

        //set default mood
        localStorage.setItem('mode', '<?php echo $site_default_mood; ?>');
    </script>
    <!--Custom script-->
    @if ($custom_js_properties != null)
        {!! $custom_js_properties['footer_custom_js_code'] !!}
    @endif
    <!--End custom script-->

    @if (isActivePluging('tlecommercecore'))
        <script src="{{ asset('/themes/tlcommerce/public/js/main.js?v=210') }}"></script>
    @endif

</body>

</html>
