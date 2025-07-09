<ul class="{{ $list }} {{ isset($column) ? $column : '' }}">
    @foreach ($main_menuTree as $menuItem)
        <li class="{{ !empty($menuItem->children) ? 'menu-item-has-children' : '' }}">
            <a href="{{ $menuItem->preview_url }}"
                class="single-header-menu {{ getActiveMenuColor($menuItem->index, $data) }}">
                {{ $menuItem->title }}
                @if (!empty($menuItem->children) && !isset($column))
                    <img class="svg ml-10"
                        src="{{ asset('themes/newslooks/public/') }}/img/icon/angle-{{ $menuItem->level > 1 ? 'right' : 'down' }}.svg"
                        alt="">
                @endif
            </a>
            @if (!empty($menuItem->children))
                @include('theme/default::frontend.includes.menu', [
                    'main_menuTree' => $menuItem->children,
                    'list' => 'sub-menu',
                    'data' => $data,
                ])
            @endif
        </li>
    @endforeach
    @if ($list != 'sub-menu')
        @if ($contact_header)
            <li class="">
                <a class="" href="{{ url('/contact') }}">{{ $contact_text }}</a>
            </li>
        @endif
        <li class="d-flex header-menu-btn-group">
            <!-- Header Button -->
            @auth
                <div class="header-btn book">
                    @if (sizeOf($header) > 0)
                        @if (!empty($header['dash_button_text']))
                            <a href="{{ route('plugin.saas.user.dashboard') }}"
                                class="btn-crs plug dash">{{ front_translate($header['dash_button_text']) }}</a>
                        @else
                            <a href="{{ route('plugin.saas.user.dashboard') }}"
                                class="btn-crs plug dash">{{ front_translate('Dashboard') }}</a>
                        @endif
                    @else
                        <a href="{{ route('plugin.saas.user.dashboard') }}"
                            class="btn-crs plug dash">{{ front_translate('Dashboard') }}</a>
                    @endif
                </div>
            @else
                <div class="header-btn book">
                    @if (sizeOf($header) > 0)
                        @if (!empty($header['login_button_text']))
                            <a href="{{ route('subscriber.login') }}"
                                class="btn-crs plug login">{{ front_translate($header['login_button_text']) }}</a>
                        @else
                            <a href="{{ route('subscriber.login') }}"
                                class="btn-crs plug login">{{ front_translate('Login') }}</a>
                        @endif
                    @else
                        <a href="{{ route('subscriber.login') }}"
                            class="btn-crs plug login">{{ front_translate('Login') }}</a>
                    @endif
                </div>
                <div class="header-btn book">
                    @if (sizeOf($header) > 0)
                        @if (!empty($header['registratiion_button_text']))
                            <a href="{{ route('plugin.saas.user.registration') }}"
                                class="btn-crs plug reg">{{ front_translate($header['registratiion_button_text']) }}</a>
                        @else
                            <a href="{{ route('plugin.saas.user.registration') }}"
                                class="btn-crs plug reg">{{ front_translate('sign up') }}</a>
                        @endif
                    @else
                        <a href="{{ route('plugin.saas.user.registration') }}"
                            class="btn-crs plug reg">{{ front_translate('sign up') }}</a>
                    @endif
                </div>
            @endauth


            @if (!empty($header['language_option']))
                <div class="header-btn book">
                    <select class="bg-light py-1 px-2 form-control-lg language-change">
                        @foreach ($languages as $language)
                            <option value="{{ $language->code }}" @selected($language->code == getFrontLocale()) class="form-control">
                                {{ $language->native_name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <!-- End Header Button -->
        </li>
    @endif
</ul>
