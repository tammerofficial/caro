{{-- Theme Option Navbar --}}
@canany(['Manage Theme General settings', 'Manage Widget'])
    <li
        class="{{ Request::routeIs(['theme.default.options', 'theme.default.widgets']) ? 'active sub-menu-opened' : '' }}">
        <a href="#">
            <i class="icofont-ui-theme"></i>
            <span class="link-title">{{ translate('Theme Options') }}</span>
        </a>
        <ul class="nav sub-menu">
            @can('Manage Theme General settings')
                <li class="{{ Request::routeIs(['theme.default.options']) ? 'active ' : '' }}">
                    <a href="{{ route('theme.default.options') }}">{{ translate('General Settings') }}</a>
                </li>
            @endcan

            @can('Manage Widget')
                <li class="{{ Request::routeIs('theme.default.widgets') ? 'active ' : '' }}">
                    <a href="{{ route('theme.default.widgets') }}">{{ translate('Widgets') }}</a>
                </li>
            @endcan
        </ul>
    </li>
@endcanany
