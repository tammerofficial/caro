<!--Theme Options Modules-->
@if (auth()->user()->can('Manage Theme General settings') ||
        auth()->user()->can('Manage Home Page Builder') ||
        auth()->user()->can('Manage Slider Settings') ||
        auth()->user()->can('Manage Widget'))
    <li
        class="{{ Request::routeIs(['theme.tlcommerce.home.page.sections.edit', 'theme.tlcommerce.home.page.sections.new', 'theme.tlcommerce.home.page.sections', 'theme.tlcommerce.sliders.edit', 'theme.tlcommerce.sliders.new', 'theme.tlcommerce.sliders', 'theme.tlcommerce.options']) ? 'active sub-menu-opened' : '' }}">
        <a href="#">
            <i class="icofont-ui-theme"></i>
            <span class="link-title">{{ translate('Theme Options') }}</span>
        </a>
        <ul class="nav sub-menu">
            @if (auth()->user()->can('Manage Theme General settings'))
                <li class="{{ Request::routeIs(['theme.tlcommerce.options']) ? 'active ' : '' }}">
                    <a href="{{ route('theme.tlcommerce.options') }}">{{ translate('General settings') }}</a>
                </li>
            @endif
            @if (auth()->user()->can('Manage Home Page Builder'))
                <li
                    class="{{ Request::routeIs(['theme.tlcommerce.home.page.sections.edit', 'theme.tlcommerce.home.page.sections']) ? 'active ' : '' }}">
                    <a href="{{ route('theme.tlcommerce.home.page.sections') }}">{{ translate('Home Page Builder') }}</a>
                </li>
            @endif
            @if (auth()->user()->can('Manage Slider Settings'))
                <li class="{{ Request::routeIs(['theme.tlcommerce.sliders']) ? 'active ' : '' }}">
                    <a href="{{ route('theme.tlcommerce.sliders') }}">{{ translate('Slider Settings') }}</a>
                </li>
            @endif
            @if (auth()->user()->can('Manage Widget'))
                <!--Widget Module-->
                <li class="{{ Request::routeIs(['theme.tlcommerce.widgets']) ? 'active ' : '' }}">
                    <a href="{{ route('theme.tlcommerce.widgets') }}">
                        <span class="link-title">{{ translate('Widgets') }}</span>
                    </a>
                </li>
                <!--End Widget Module-->
            @endif
        </ul>
    </li>
@endif
<!--End Theme Options Modules-->
