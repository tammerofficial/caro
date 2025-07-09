@php
    $tenant_id = getGeneralSetting('tenant_id');
@endphp
@extends('theme/tlcommerce::frontend.layouts.master')
@section('seo')
    @if ($page_details != null)
        <title> {{ $page_details->name }}</title>
        <meta name="title" content="{{ $page_details->meta_title }}" />
        <meta name="description" content="{{ $page_details->meta_description }}" />
        <meta name="keywords" content="{{ getGeneralSetting('site_meta_keywords') }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{ $page_details->meta_title }}" />
        <meta property="og:description" content="{{ $page_details->meta_description }}" />
        <meta name="twitter:card" content="{{ $page_details->meta_title }}" />
        <meta name="twitter:title" content="{{ $page_details->meta_title }}" />
        <meta name="twitter:description" content="{{ $page_details->meta_description }}" />
        <meta name="twitter:image" content="{{ $page_details->meta_image }}" />
        <meta property="og:image" content="{{ $page_details->meta_image }}" />
        <meta property="og:image:width" content="1200" />
    @else
        <title>{{ getGeneralSetting('site_title') }}</title>
        <meta name="title" content="{{ getGeneralSetting('site_meta_title') }}" />
        <meta name="description" content="{{ getGeneralSetting('site_meta_description') }}" />
        <meta name="keywords" content="{{ getGeneralSetting('site_meta_keywords') }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{ getGeneralSetting('site_meta_title') }}" />
        <meta property="og:description" content="{{ getGeneralSetting('site_meta_description') }}" />
        <meta name="twitter:card" content="{{ getGeneralSetting('site_meta_description') }}" />
        <meta name="twitter:title" content="{{ getGeneralSetting('site_meta_title') }}" />
        <meta name="twitter:description" content="{{ getGeneralSetting('site_meta_description') }}" />
        <meta name="twitter:image" content="{{ getFilePath(getGeneralSetting('site_meta_image')) }}" />
        <meta property="og:image" content="{{ getFilePath(getGeneralSetting('site_meta_image')) }}" />
    @endif
@endsection

@section('builder-css-link')
    @if ($page_details)
        @php
            $active_theme = getActiveTheme();
            $builder_css_file = base_path("themes/{$active_theme->location}/public/builder-assets/{$tenant_id}/css/{$page_details->permalink}.css");
            $builder_css_path = "/themes/{$active_theme->location}/public/builder-assets/{$tenant_id}/css/{$page_details->permalink}.css";
        @endphp

        @if (isActivePluging('tlcommerce-pagebuilder') &&
                $page_details->page_type == 'builder' &&
                file_exists($builder_css_file))
            <link rel="stylesheet" href="{{ asset($builder_css_path . '?v=' . time()) }}">
        @endif
    @endif
@endsection
