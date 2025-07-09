@php
    $site_seo_properties = cache()->rememberForever('site-seo-properties', function () {
        return \Core\Repositories\SettingsRepository::siteSeoProperties();
    });

    $tenant_id = getGeneralSetting('tenant_id');
@endphp
@extends('theme/tlcommerce::frontend.layouts.master')
@section('seo')
    <title>{{ $site_seo_properties['site_title'] }}</title>
    <meta name="title" content="{{ $site_seo_properties['site_meta_title'] }}" />
    <meta name="description" content="{{ $site_seo_properties['site_meta_description'] }}" />
    <meta name="keywords" content="{{ $site_seo_properties['site_meta_keywords'] }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $site_seo_properties['site_meta_title'] }}" />
    <meta property="og:description" content="{{ $site_seo_properties['site_meta_description'] }}" />
    <meta property="og:image" content="{{ $site_seo_properties['site_meta_image'] }}" />
    <meta name="twitter:card" content="{{ $site_seo_properties['site_meta_description'] }}" />
    <meta name="twitter:title" content="{{ $site_seo_properties['site_meta_title'] }}" />
    <meta name="twitter:description" content="{{ $site_seo_properties['site_meta_description'] }}" />
    <meta name="twitter:image" content="{{ $site_seo_properties['site_meta_image'] }}" />
@endsection

@section('builder-css-link')
    @if (isActivePluging('tlcommerce-pagebuilder') && isset($page) && $page->page_type == 'builder')
        @php
            $active_theme = getActiveTheme();
            $builder_css_file = base_path("themes/{$active_theme->location}/public/builder-assets/{$tenant_id}/css/{$page->permalink}.css");
            $builder_css_path = asset("themes/{$active_theme->location}/public/builder-assets/{$tenant_id}/css/{$page->permalink}.css");
        @endphp
        @if (file_exists($builder_css_file))
            <link rel="stylesheet" href="{{ $builder_css_path . '?v=' . time() }}">
        @endif
    @endif
@endsection
