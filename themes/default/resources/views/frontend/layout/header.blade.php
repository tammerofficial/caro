@php
// Theme Option and Settings
$languages = getAllActiveLanguages();
$header_logo = isset($logo_details['white_background_logo']) ? $logo_details['white_background_logo'] : null;
$mobile_logo = isset($logo_details['white_mobile_background_logo']) ? $logo_details['white_mobile_background_logo'] : null;
$sticky_header_logo = isset($logo_details['sticky_background_logo']) ? $logo_details['sticky_background_logo'] : null;
$mobile_sticky_header_logo = isset($logo_details['sticky_mobile_background_logo']) ? $logo_details['sticky_mobile_background_logo'] : null;

$dark_header_logo = isset($logo_details['black_background_logo']) ? $logo_details['black_background_logo'] : null;
$dark_mobile_logo = isset($logo_details['black_mobile_background_logo']) ? $logo_details['black_mobile_background_logo'] : null;
$dark_sticky_header_logo = isset($logo_details['sticky_black_background_logo']) ? $logo_details['sticky_black_background_logo'] : null;
$dark_mobile_sticky_header_logo = isset($logo_details['sticky_black_mobile_background_logo']) ? $logo_details['sticky_black_mobile_background_logo'] : null;

$text_logo = isset($logo_details['system_name']) ? $logo_details['system_name'] : null;

$contact_header = isset($contact['contact_header_menu']) && $contact['contact_header_menu'] == 1 ? true : false;
$contact_text = isset($contact['contact_header_text']) && $contact['contact_header_text'] != '' ? front_translate($contact['contact_header_text']) : front_translate('Contact');

$mood = 'light';
if (session()->has('frontend-mood')) {
$mood = session()->get('frontend-mood');
}

$menu_position = getMenuPositionId(config('default.menu_position')[0]);
$data = getMenuStructure($menu_position);
$main_menuTree = buildMenuTree($data);

$currentRoute = Route::currentRouteName();
@endphp
<!-- Header -->
<header class="header home-header">
    <div class="header-fixed">
        <div class="container position-relative">
            <div class="row d-flex align-items-center logo-area">
                <div class="col-lg-3 col-md-4 col-6">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{ route('theme.default.home') }}">
                            @if ($mood === 'dark')
                            <!-- Main Header Logo -->
                            @if (isset($dark_header_logo))
                            <img src="{{ project_asset($dark_header_logo) }}" alt="Logo" class="img-fluid default-logo">
                            @elseif(isset($text_logo))
                            <h2 class="default-logo"> {{ $text_logo }}</h2>
                            @endif
                            <!-- Main Header Mobile Logo -->
                            @if (isset($dark_mobile_logo))
                            <img src="{{ project_asset($dark_mobile_logo) }}" alt="Logo" class="img-fluid mobile-logo">
                            @elseif(isset($text_logo))
                            <h2 class="mobile-logo"> {{ $text_logo }} </h2>
                            @endif

                            <!-- Sticky Header Logo -->
                            @if (isset($dark_sticky_header_logo))
                            <img src="{{ project_asset($dark_sticky_header_logo) }}" alt="Logo" class="img-fluid sticky-logo">
                            @elseif(isset($text_logo))
                            <h2 class="sticky-logo"> {{ $text_logo }} </h2>
                            @endif
                            <!-- Sticky Header Mobile Logo -->
                            @if (isset($dark_mobile_sticky_header_logo))
                            <img src="{{ project_asset($dark_mobile_sticky_header_logo) }}" alt="Logo" class="img-fluid sticky-mobile-logo">
                            @elseif(isset($text_logo))
                            <h2 class="sticky-mobile-logo"> {{ $text_logo }} </h2>
                            @endif
                            @else
                            <!-- Main Header Logo -->
                            @if (isset($header_logo))
                            <img src="{{ project_asset($header_logo) }}" alt="Logo" class="img-fluid default-logo">
                            @elseif(isset($text_logo))
                            <h2 class="default-logo"> {{ $text_logo }} </h2>
                            @endif
                            <!-- Main Header Mobile Logo -->
                            @if (isset($mobile_logo))
                            <img src="{{ project_asset($mobile_logo) }}" alt="Logo" class="img-fluid mobile-logo">
                            @elseif(isset($text_logo))
                            <h2 class="mobile-logo"> {{ $text_logo }} </h2>
                            @endif
                            <!-- Sticky Header Logo -->
                            @if (isset($sticky_header_logo))
                            <img src="{{ project_asset($sticky_header_logo) }}" alt="Logo" class="img-fluid sticky-logo">
                            @elseif(isset($text_logo))
                            <h2 class="sticky-logo"> {{ $text_logo }} </h2>
                            @endif
                            <!-- Sticky Header Mobile Logo -->
                            @if (isset($mobile_sticky_header_logo))
                            <img src="{{ project_asset($mobile_sticky_header_logo) }}" alt="Logo" class="img-fluid sticky-mobile-logo">
                            @elseif(isset($text_logo))
                            <h2 class="sticky-mobile-logo"> {{ $text_logo }} </h2>
                            @endif
                            @endif
                        </a>
                    </div>
                    <!-- End of Logo -->
                </div>

                <div class="col-lg-9 col-md-8 col-6 d-flex justify-content-end position-static align-itemes-center">
                    <!-- Nav Menu -->
                    <div class="d-none d-md-block nav-menu-cover header-menu">
                        @include('theme/default::frontend.includes.menu', [
                        'main_menuTree' => $main_menuTree,
                        'list' => 'nav nav-menu align-itemes-center',
                        'data' => $data,
                        ])
                    </div>

                    <div class="d-block d-md-none nav-menu-cover header-menu mobile">
                        @include('theme/default::frontend.includes.menu', [
                        'main_menuTree' => $main_menuTree,
                        'list' => 'nav nav-menu align-itemes-center',
                        'data' => $data,
                        ])
                    </div>

                    <!-- Mobile -->
                    <!-- End of Nav Menu -->

                    <!-- Mobile Menu -->
                    <div class="mobile-menu-cover">
                        <ul class="nav mobile-nav-menu">
                            <li class="nav-menu-toggle">
                                <img src="{{ asset('themes/default/public/assets/images/menu-toggler.svg') }}" alt="" class="img-fluid svg">
                            </li>
                        </ul>
                    </div>
                    <!-- End of Mobile Menu -->
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End of Header -->