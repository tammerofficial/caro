<?php
    // Theme Options and Settings
    $generalSettings = getGeneralSettingsDetails();
    $active_theme = getActiveTheme();
    $back_to_top = getThemeOption('back_to_top', $active_theme->id);
    $preloader = getThemeOption('preloader', $active_theme->id);
    $header = getThemeOption('header', $active_theme->id);
    $subscribe = getThemeOption('subscribe', $active_theme->id);
    $footer = getThemeOption('footer', $active_theme->id);
    $contact = getThemeOption('contact', $active_theme->id);
    $theme_color = getThemeOption('theme_color', $active_theme->id);

    $sidebar_options = themeOptionToCss('sidebar_options', $active_theme->id);
    $page_options = themeOptionToCss('page', $active_theme->id);
    $body_typography = themeOptionToCss('body_typography', $active_theme->id);
    $paragraph_typography = themeOptionToCss('paragraph_typography', $active_theme->id);
    $heading_typography = themeOptionToCss('heading_typography', $active_theme->id);
    $menu_typography = themeOptionToCss('menu_typography', $active_theme->id);
    $button_typography = themeOptionToCss('button_typography', $active_theme->id);
    $custom_js_properties = getThemeOption('custom_js', $active_theme->id);

    $mood = 'light';
    if (session()->has('frontend-mood')) {
        $mood = session()->get('frontend-mood');
    }
    $rtl = getActiveFrontLangRTL();

    $primary_color =
        $theme_color['theme_primary_color'] != null
            ? str_replace('#', '', $theme_color['theme_primary_color'])
            : 'ff7171';
    $currentRoute = Route::currentRouteName();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="<?php echo e(csrf_token()); ?>">

    <!-- Document SEO and Title -->
    <?php echo $__env->yieldContent('seo'); ?>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png"
        href="<?php echo e(isset($generalSettings['favicon']) ? project_asset($generalSettings['favicon']) : ''); ?>">

    <!--==== Google Fonts ====-->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">

    <!-- Critical CSS Files -->

    <!--==== Bootstrap css file ====-->
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/bootstrap.min.css')); ?>">

    <!--==== Style css file ====-->
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/style.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/page_style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/custom.css')); ?>">

    <?php if($theme_color['theme_primary_color'] != null): ?>
        <link rel="stylesheet"
            href="<?php echo e(asset('themes/default/public/assets/css/theme-color.php')); ?>?color=<?php echo e($primary_color); ?>">
    <?php endif; ?>

    <!-- Including all google fonts link -->
    <?php if ($__env->exists('theme/default::frontend.includes.custom.google-font-link', [
        'sidebar_options' => $sidebar_options,
        'page_options' => $page_options,
        'body_typography' => $body_typography,
        'paragraph_typography' => $paragraph_typography,
        'heading_typography' => $heading_typography,
        'menu_typography' => $menu_typography,
        'button_typography' => $button_typography,
    ])) echo $__env->make('theme/default::frontend.includes.custom.google-font-link', [
        'sidebar_options' => $sidebar_options,
        'page_options' => $page_options,
        'body_typography' => $body_typography,
        'paragraph_typography' => $paragraph_typography,
        'heading_typography' => $heading_typography,
        'menu_typography' => $menu_typography,
        'button_typography' => $button_typography,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Including all dynamic css -->
    <?php if ($__env->exists('theme/default::frontend.includes.custom.dynamic-css', [
        'body_typography' => $body_typography,
        'paragraph_typography' => $paragraph_typography,
        'heading_typography' => $heading_typography,
        'menu_typography' => $menu_typography,
        'button_typography' => $button_typography,
    ])) echo $__env->make('theme/default::frontend.includes.custom.dynamic-css', [
        'body_typography' => $body_typography,
        'paragraph_typography' => $paragraph_typography,
        'heading_typography' => $heading_typography,
        'menu_typography' => $menu_typography,
        'button_typography' => $button_typography,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('custom-css'); ?>
    <!--==== Custom css file ====-->
    <!--Custom script-->
    <?php if($custom_js_properties != null): ?>
        <?php echo $custom_js_properties['header_custom_js_code']; ?>

    <?php endif; ?>
    <!--End custom script-->
</head>

<body
    class="<?php if($mood == 'dark'): ?> dark <?php endif; ?> <?php if($rtl): ?> rtl-mode <?php endif; ?> <?php if($currentRoute == 'theme.default.home'): ?> home-page <?php endif; ?>">
    <!-- Preloader -->
    <?php if(isset($preloader['preloader_field']) && $preloader['preloader_field'] == 1): ?>
        <div class="preloader">
            <div class="preload-img">
                <?php if(isset($preloader['preloader_style_type']) && $preloader['preloader_style_type'] == 'custom'): ?>
                    <?php if(isset($preloader['custom_preloader_type']) &&
                            $preloader['custom_preloader_type'] == 'image' &&
                            isset($preloader['preloader_image'])): ?>
                        <img src="<?php echo e(getFilePath($preloader['preloader_image'])); ?>" alt="Preloader Image"
                            class="pre-img svg">
                    <?php endif; ?>
                    <?php if(isset($preloader['custom_preloader_type']) &&
                            $preloader['custom_preloader_type'] == 'text' &&
                            isset($preloader['preloader_html'])): ?>
                        <?php echo xss_clean($preloader['preloader_html']); ?>

                    <?php endif; ?>
                <?php else: ?>
                    <div class="spinnerBounce">
                        <div class="double-bounce1"></div>
                        <div class="double-bounce2"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <!-- End of Preloader -->

    <?php if ($__env->exists('theme/default::frontend.layout.header', [
        'header' => $header,
        'logo_details' => $generalSettings,
        'contact' => $contact,
    ])) echo $__env->make('theme/default::frontend.layout.header', [
        'header' => $header,
        'logo_details' => $generalSettings,
        'contact' => $contact,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <?php echo $__env->yieldContent('content'); ?>

    <!-- Back to Top Button -->
    <?php if(isset($back_to_top['back_to_top_button']) && $back_to_top['back_to_top_button'] == 1): ?>
        <div class="back-to-top custom-style">
            <?php if(isset($back_to_top['custom_back_to_top_button']) &&
                    $back_to_top['custom_back_to_top_button'] == 1 &&
                    isset($back_to_top['custom_back_to_top_button_icon']) &&
                    $back_to_top['custom_back_to_top_button_icon'] != ''): ?>
                <span><i class="fa <?php echo e($back_to_top['custom_back_to_top_button_icon']); ?>"></i></span>
            <?php else: ?>
                <span><i class="fa fa-long-arrow-up"></i></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <!-- End of Back to Top Button -->

    <?php if ($__env->exists('theme/default::frontend.layout.footer', [
        'white_logo' => isset($generalSettings['white_background_logo'])
            ? $generalSettings['white_background_logo']
            : null,
        'dark_logo' => isset($generalSettings['black_background_logo'])
            ? $generalSettings['black_background_logo']
            : null,
        'text_logo' => isset($generalSettings['system_name']) ? $generalSettings['system_name'] : '',
        'copyright_text' => isset($generalSettings['copyright_text']) ? $generalSettings['copyright_text'] : '',
        'footer' => $footer,
        'mood' => $mood,
    ])) echo $__env->make('theme/default::frontend.layout.footer', [
        'white_logo' => isset($generalSettings['white_background_logo'])
            ? $generalSettings['white_background_logo']
            : null,
        'dark_logo' => isset($generalSettings['black_background_logo'])
            ? $generalSettings['black_background_logo']
            : null,
        'text_logo' => isset($generalSettings['system_name']) ? $generalSettings['system_name'] : '',
        'copyright_text' => isset($generalSettings['copyright_text']) ? $generalSettings['copyright_text'] : '',
        'footer' => $footer,
        'mood' => $mood,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <!-- Non Critical CSS Files Start -->
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/back_to_top.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/preloader.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/header.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/header_logo.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/menu.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/mobile_menu.css')); ?>"
        media="screen and (max-width: 991px)">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/sidebar_options.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/page.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/subscribe.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/footer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/page_404.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/custom_css.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(asset('themes/default/public/assets/plugins/magnific-popup/magnific-popup.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/plugins/animate/animate.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/default/public/assets/css/font-awesome.min.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(asset('themes/default/public/assets/plugins/owl-carousel/owl.carousel.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/public/backend/assets/css/toaster.min.css')); ?>">
    <!-- Non Critical CSS Files End -->


    <!-- JS Files -->

    <!-- ==== JQuery 3.6.4 js file ==== -->
    <script src="<?php echo e(asset('themes/default/public/assets/js/jquery.min.js')); ?>"></script>

    <!-- ==== Bootstrap js file ==== -->
    <script src="<?php echo e(asset('themes/default/public/assets/js/bootstrap.bundle.min.js')); ?>" async></script>

    <!-- ==== Owl Carousel ==== -->
    <script src="<?php echo e(asset('themes/default/public/assets/plugins/owl-carousel/owl.carousel.min.js')); ?>"></script>

    <!-- ==== Magnific Popup ==== -->
    <script src="<?php echo e(asset('themes/default/public/assets/plugins/magnific-popup/jquery.magnific-popup.min.js')); ?>" defer>
    </script>

    <!-- ==== Script js file ==== -->
    <script src="<?php echo e(asset('themes/default/public/assets/js/scripts.js')); ?>" defer></script>

    <!-- ==== Custom js file ==== -->
    <script src="<?php echo e(asset('themes/default/public/assets/js/custom.js')); ?>" async></script>

    <!-- Lazy Load -->
    <script type="text/javascript"
        src="<?php echo e(asset('themes/default/public/assets/plugins/jquery-lazy/jquery.lazy.min.js')); ?>"></script>

    <!-- ======= TOASTER ======= -->
    <script src="<?php echo e(asset('/public/backend/assets/js/toaster.min.js')); ?>"></script>
    <?php echo Toastr::message(); ?>

    <!-- ======= TOASTER ======= -->

    <script>
        // setting up the csrf token for ajax request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        (function($) {
            'use strict';
            $(document).ready(function() {

                $('.single-header-menu').on('click', function() {
                    $('.single-header-menu').removeClass('active-menu-item')
                    $(this).addClass('active-menu-item')
                })

                $('.newsletter input[name="email"]').on('keypress', function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                    }
                });

                // preventing submitting newsletter if not checked the privacy policy 
                let submitButton = $('.newsletter .newsletterForm button');
                let submitCheckbox = $('.newsletter .newsletterForm .checkbox-cover input[type="checkbox"]');

                if (submitCheckbox.length > 0) {
                    submitButton.prop("disabled", true);
                    submitButton.css({
                        'cursor': 'not-allowed'
                    });
                    submitCheckbox.on('click', function() {
                        if (submitCheckbox.is(':checked')) {
                            submitButton.prop("disabled", false);
                            submitButton.css({
                                'cursor': 'pointer'
                            });
                        } else {
                            submitButton.prop("disabled", true);
                            submitButton.css({
                                'cursor': 'not-allowed'
                            });
                        }
                    })
                    submitButton.on('click', function(e) {
                        e.preventDefault();
                        if (submitCheckbox.is(':checked')) {
                            $(this).closest('form').submit();
                        }
                    });
                };

                let footerSubmitButton = $('.footerNewsletter .newsletterForm button');
                let footerSubmitCheckbox = $(
                    '.footerNewsletter .newsletterForm .footer-checkbox-cover input[type="checkbox"]');

                if (footerSubmitCheckbox.length > 0) {
                    footerSubmitButton.prop("disabled", true);
                    footerSubmitButton.css({
                        'cursor': 'not-allowed'
                    });
                    footerSubmitCheckbox.on('click', function() {
                        if (footerSubmitCheckbox.is(':checked')) {
                            footerSubmitButton.prop("disabled", false);
                            footerSubmitButton.css({
                                'cursor': 'pointer'
                            });
                        } else {
                            footerSubmitButton.prop("disabled", true);
                            footerSubmitButton.css({
                                'cursor': 'not-allowed'
                            });
                        }
                    })
                    footerSubmitButton.on('click', function(e) {
                        e.preventDefault();
                        if (footerSubmitCheckbox.is(':checked')) {
                            $(this).closest('form').submit();
                        }
                    });
                };

                $('.newsletterForm').on('submit', function(e) {
                    e.preventDefault();
                    let email = $(this).find('input[name="email"]').val();
                    newsletterStore(email);
                    $(this).find('input[name="email"]').val('');
                });

                // Blog Search Form
                $(document).on('submit', '#nav-search-form', function(e) {
                    e.preventDefault();
                    let text = $('.search-text').val();
                    if (text.length > 0) {
                        submitSearch(text);
                    }
                });

                // onclick search icon
                $(document).on('click', '.input-group-append', function(e) {
                    e.preventDefault();
                    let text = $('.search-text').val();
                    if (text.length > 0) {
                        submitSearch(text);
                    }

                });

                // Search Submit
                function submitSearch(text) {
                    let url = '<?php echo e(route('theme.default.blogBySearch', 'searchText')); ?>';
                    url = url.replace("searchText", text);
                    window.location.href = url;
                }

                // language change
                $('.language-change').on('change', function() {
                    let value = $(this).val();
                    console.log(value)
                    if (value) {
                        $.post('<?php echo e(route('theme.default.language.change')); ?>', {
                            lang: value
                        }, function(data) {
                            location.reload();
                        });
                    }
                });

                /**
                 * Change dark mood
                 */
                $('.darklooks-mode-changer').on('click', function(e) {
                    e.preventDefault();
                    $.post('<?php echo e(route('theme.default.mood.change')); ?>', {}, function(data) {
                        window.location.href = window.location.href;
                    })
                });

                $('.lazy').Lazy({
                    // your configuration goes here
                    scrollDirection: 'vertical',
                    effect: 'fadeIn',
                    visibleOnly: true
                });
            });

            // newsletter store method 
            function newsletterStore(email) {
                $.ajax({
                    type: 'post',
                    url: '<?php echo e(route('theme.default.newsletter.store')); ?>',
                    data: {
                        email: email
                    },
                    success: function(res) {
                        if (res.success) {
                            toastr.success(res.message, "<?php echo e(front_translate('Success!')); ?>");
                        } else {
                            toastr.error(res.message, "<?php echo e(front_translate('Error!')); ?>");
                        }
                    },
                    error: function(data, textStatus, jqXHR) {
                        toastr.error("Subscription Action Failed" + textStatus,
                            "<?php echo e(front_translate('Error!')); ?>");
                    }
                });
            }

            // RTL Init
            let RTL = false;
            if ('<?php echo e($rtl); ?>') {
                RTL = true;
            }

            // Most Commented Blog Carousel
            // the class is specified to comment section or it will conflict with slider carousel
            let checkData = function checkData(data, value) {
                return typeof data === "undefined" ? value : data;
            };

            let $owlCarousel = $(".widget-most-commented-post .owl-carousel");
            $owlCarousel.each(function() {
                let $t = $(this);
                $t.owlCarousel({
                    rtl: RTL,
                    items: checkData($t.data("owl-items"), 1),
                    margin: checkData($t.data("owl-margin"), 0),
                    loop: checkData($t.data("owl-loop"), true),
                    smartSpeed: 1000,
                    autoplay: checkData($t.data("owl-autoplay"), false),
                    autoplayTimeout: checkData($t.data("owl-speed"), 8000),
                    center: checkData($t.data("owl-center"), false),
                    animateIn: checkData($t.data("owl-animate-in"), false),
                    animateOut: checkData($t.data("owl-animate-out"), false),
                    nav: checkData($t.data("owl-nav"), false),
                    navText: [
                        '<i class="fa fa-angle-left"></i>',
                        '<i class="fa fa-angle-right"></i>',
                    ],
                    dots: checkData($t.data("owl-dots"), false),
                    responsive: checkData($t.data("owl-responsive"), {
                        0: {
                            items: 1,
                            nav: false
                        },
                        575: {
                            items: 1,
                            nav: false
                        },
                        767: {
                            items: 2,
                            nav: false
                        }
                    }),
                    mouseDrag: checkData($t.data("owl-mouse-drag"), false),
                });
            });
            // Banner Slider Carousal Initialize End

        })(jQuery);
    </script>
    <!--Custom script-->
    <?php if($custom_js_properties != null): ?>
        <?php echo $custom_js_properties['footer_custom_js_code']; ?>

    <?php endif; ?>
    <!--End custom script-->
    <?php echo $__env->yieldContent('custom-js'); ?>

</body>

</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/themes/default/resources/views/frontend/layout/master.blade.php ENDPATH**/ ?>