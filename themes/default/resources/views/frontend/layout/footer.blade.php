@php
    // Theme Options and Setting
    $active_theme = getActiveTheme();
    $social_options = getThemeOption('social', $active_theme->id);
    $is_social = true;
    $is_logo = true;
    $is_text = true;

    $all_socials = isset($social_options['social_field']) ? json_decode($social_options['social_field']) : null;
    $footer_logo = isset($white_logo) ? project_asset($white_logo) : null;
    if ($mood === 'dark') {
        $footer_logo = isset($dark_logo) ? project_asset($dark_logo) : null;
    }
    $logo_url = route('theme.default.home');
    $logo_alignment = 'center';
    $text_alignment = $rtl ? 'left' : 'right';
    $social_alignment = $rtl ? 'right' : 'left';
    $lang_alignment = $rtl ? 'right' : 'left';
    $footer_copyright_text = $copyright_text;
    $languages = getAllActiveLanguages();

    if (isset($footer['custom_footer_style']) && $footer['custom_footer_style'] == 1) {
        $is_social = isset($footer['footer_social_enable']) && $footer['footer_social_enable'] == 1 ? true : false;
        if (isset($footer['footer_logo_enable']) && $footer['footer_logo_enable'] == 1) {
            $is_logo = true;
            $logo_url = isset($footer['footer_logo_anchor_url']) ? $footer['footer_logo_anchor_url'] : '';
            $logo_alignment = isset($footer['footer_logo_alignment']) ? $footer['footer_logo_alignment'] : 'center';
        } else {
            $is_logo = false;
        }
        if (isset($footer['footer_text_enable']) && $footer['footer_text_enable'] == 1) {
            $is_text = true;
            $text_alignment = isset($footer['footer_text_alignment']) ? $footer['footer_text_alignment'] : 'right';
        } else {
            $is_text = false;
        }
    }

    $lang = isset($footer['footer_language_select']) && $footer['footer_language_select'] == 1 ? true : false;

    $email_placeholder = isset($newsletter_fields['email_placeholder']) ? $newsletter_fields['email_placeholder'] : '';
    $button_text = isset($newsletter_fields['button_text']) ? $newsletter_fields['button_text'] : '';
    $subscribe = getThemeOption('subscribe', $active_theme->id);

    $is_privacy = false;
    if (
        isset($subscribe['privacy_policy']) &&
        $subscribe['privacy_policy'] == 1 &&
        isset($subscribe['privacy_policy_page'])
    ) {
        $is_privacy = true;
    }
@endphp
<!-- Footer -->
<footer class="footer footer-container plugin-footer text-white pt-4">
    <div class="footer-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-5 col-sm-10 col-12">
                    <!-- Widget Text -->
                    <div class="widget widget_text">
                        @if ($is_logo && $footer_logo != null)
                            @php
                                if (!str_contains($logo_url, 'https://') || !str_contains($logo_url, 'http://')) {
                                    $logo_url = 'http://' . $logo_url;
                                }
                            @endphp
                            <a href="{{ $logo_url }}"><img src="{{ $footer_logo }}" alt="logo"
                                    class="img-fluid"></a>
                        @else
                            <h2 class="footer-logo">{{ $text_logo }}</h2>
                        @endif

                        @if (!empty($footer['footer_content']))
                            <p class="mt-3">
                                {{ front_translate($footer['footer_content']) }}
                            </p>
                        @endif

                        <div class="social-icon plug footer-social">
                            @if ($is_social)
                                @isset($all_socials)
                                    @foreach ($all_socials as $social)
                                        @if ($social->social_icon != '')
                                            @php
                                                $logo_url = $social->social_icon_url;
                                                if (
                                                    $social->social_icon_url === '' ||
                                                    $social->social_icon_url === '/'
                                                ) {
                                                    $logo_url = url('/') . $social->social_icon_url;
                                                }
                                            @endphp
                                            <a href="{{ $logo_url }}" aria-label="icon"><i
                                                    class="fa {{ $social->social_icon }}"></i></a>
                                        @endif
                                    @endforeach
                                @endisset
                            @endif
                        </div>
                    </div>
                    <!-- End Widget Text -->
                </div>

                @if (!empty($footer_left_menu))
                    <div class="col-lg-2 col-md-5 col-sm-10 col-12">
                        <!-- Footer Menu -->
                        <div class="widget widget_footer_menu">
                            <!-- Widget Title -->
                            <div class="widget_title">
                                @if (sizeOf($footer_left_menu) > 0)
                                    <h3 class="custom-title-style">{{ $footer_left_menu[0]->group_name }}</h3>
                                @endif
                            </div>
                            <!-- End Widget Title -->

                            <div class="footer_menu plug">
                                <ul>
                                    @foreach ($footer_left_menu as $menu)
                                        <li><a href="{{ $menu->url }}">{{ $menu->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- End Footer Menu -->
                    </div>
                @endif
                @if (!empty($footer_left_menu))
                    <div class="col-lg-2 col-md-5 col-sm-10 col-12">
                        <!-- Footer Menu -->
                        <div class="widget widget_footer_menu">
                            <!-- Widget Title -->
                            <div class="widget_title">
                                @if (sizeOf($footer_right_menu) > 0)
                                    <h3 class="custom-title-style">{{ $footer_right_menu[0]->group_name }}</h3>
                                @endif
                            </div>
                            <!-- End Widget Title -->

                            <div class="footer_menu plug">
                                <ul>
                                    @foreach ($footer_right_menu as $menu)
                                        <li><a href="{{ $menu->url }}">{{ $menu->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- End Footer Menu -->
                    </div>
                @endif

                @if (!empty($subscribe['footer_subscribe_form']))
                    <div class="col-lg-4 col-md-5 col-sm-10 col-12">
                        <div class="widget widget_newsletter footerNewsletter newsletter-cover">
                            <div class="widget_title">
                                @if (!empty($subscribe['subscribe_form_title']))
                                    <h3>{{ front_translate($subscribe['subscribe_form_title']) }}</h3>
                                @endif
                            </div>

                            <form action="javascript:void(0);" method="post" class="newsletterForm">
                                @csrf
                                <div class="theme-input-group pay plug">
                                    <input class="theme-input-style" type="email" name="email"
                                        placeholder="{{ !empty($subscribe['subscribe_form_placeholder']) ? front_translate($subscribe['subscribe_form_placeholder']) : '' }}">
                                    @if ($is_privacy)
                                        <div class="m-0 d-flex mb-3 footer-checkbox-cover">
                                            @php
                                                $tlpage = Core\Models\TlPage::where(
                                                    'id',
                                                    $subscribe['privacy_policy_page'],
                                                )
                                                    ->select(['id', 'permalink', 'title'])
                                                    ->first();
                                                $parentUrl = isset($tlpage) ? getParentUrl($tlpage) : '';
                                            @endphp
                                            <input type="checkbox" class="mb-0 nl-checkbox">
                                            <p>
                                                {{ front_translate("I've read and accept the") }}
                                                @if ($tlpage != null)
                                                    <a class="font-weight-bold"
                                                        href="{{ route('theme.default.viewPage', ['permalink' => $parentUrl . $tlpage->permalink]) }}">
                                                        {{ $tlpage->translation('title', getFrontLocale()) }}
                                                    </a>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                    <button type="submit" class="btn">
                                        {{ !empty($subscribe['subscribe_form_button_text']) ? front_translate($subscribe['subscribe_form_button_text']) : '' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if ($is_text)
        <div class="justify-content-center mt-5 copyright">
            <div class="col-12">
                <div class="footer-cradit text-center">
                    {!! xss_clean($footer_copyright_text) !!}
                </div>
            </div>
        </div>
    @endif

</footer>
<!-- End Footer -->
