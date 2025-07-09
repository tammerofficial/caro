<?php
    $active_theme = getActiveTheme();
    $homepage = getThemeOption('home_page', $active_theme->id);

    $layout = $homepage['homepage_layout'];
    $generalSettings = getGeneralSettingsDetails();

    $title = $generalSettings['system_name'];
    $motto = $generalSettings['site_moto'];
    $rtl = getActiveFrontLangRTL();
?>


<?php $__env->startSection('seo'); ?>
    
    <title><?php echo e($title . '|' . $motto); ?></title>
    <meta name="title" content="<?php echo e($generalSettings['site_meta_title'] ? $generalSettings['site_meta_title'] : $title); ?>">
    <meta name="description" content="<?php echo e($generalSettings['site_meta_description']); ?>">
    <meta name="keywords" content="<?php echo e($generalSettings['site_meta_keywords']); ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo e($generalSettings['site_meta_title']); ?>">
    <meta property="og:description" content="<?php echo e($generalSettings['site_meta_description']); ?>">
    <meta name="twitter:card" content="<?php echo e($generalSettings['site_meta_description']); ?>">
    <meta name="twitter:title" content="<?php echo e($generalSettings['site_meta_title']); ?>">
    <meta name="twitter:description" content="<?php echo e($generalSettings['site_meta_description']); ?>">
    <meta name="twitter:image" content="<?php echo e(asset(getFilePath($generalSettings['site_meta_image']))); ?>">
    <meta property="og:image" content="<?php echo e(asset(getFilePath($generalSettings['site_meta_image']))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom-css'); ?>
    <?php if(isActivePluging('pagebuilder') && isset($page) && $page->page_type == 'builder'): ?>
        <?php
            $builder_css_file = base_path("themes/{$active_theme->location}/public/builder-assets/css/{$page->permalink}.css");
            $builder_css_path = asset("themes/{$active_theme->location}/public/builder-assets/css/{$page->permalink}.css");
        ?>
        <?php if(file_exists($builder_css_file)): ?>
            <link rel="stylesheet" href="<?php echo e($builder_css_path . '?v=' . time()); ?>">
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(isset($page)): ?>
        <?php if(isActivePluging('pagebuilder') && $page->page_type == 'builder'): ?>
            <?php if ($__env->exists('plugin/pagebuilder::builders.builder-section', ['page_sections' => $page_sections])) echo $__env->make('plugin/pagebuilder::builders.builder-section', ['page_sections' => $page_sections], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php else: ?>
            <div class="container">
                <div class="row">
                    <div class="<?php echo e($layout == 'full_layout' ? 'col-lg-12' : 'col-lg-8'); ?> <?php echo e($layout == 'left_sidebar_layout' ? 'order-2' : 'order-1'); ?>"
                        id="page_section">
                        <?php if($page->visibility == 'password'): ?>
                            
                            <section class="my-5" id="password_box">
                                <div class="nl-bg-ol"></div>
                                <div class="container">
                                    <div class="newsletter pt-40 pb-40">
                                        <div class="text-center mb-4">
                                            <h3>
                                                <?php echo e(front_translate('This Page is Password protected. Please Enter The Correct Password To See This Page.')); ?>

                                            </h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-10 offset-lg-1">
                                                <form action="javascript:void(0)" id="page_password_form">
                                                    <div class="input-group">
                                                        <input type="hidden" name="permalink"
                                                            value="<?php echo e($page->permalink); ?>">
                                                        <input type="password" class="form-control" id="page_password"
                                                            name="password"
                                                            placeholder="<?php echo e(front_translate('Enter Page Password')); ?>">
                                                    </div>
                                                </form>
                                                <span class="text-danger my-2" id="password_message"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            
                        <?php endif; ?>
                        <div id="page_details">
                            <div class="page-thumb">
                                <?php if(isset($page->page_image)): ?>
                                    <img src="<?php echo e(asset(getFilePath($page->page_image))); ?>" alt=""
                                        class="img-fluid">
                                <?php endif; ?>
                            </div>
                            <div class="page_content">
                                
                                <?php echo xss_clean(fix_image_urls($page->translation('content', getLocale()))); ?>

                                
                            </div>
                        </div>
                    </div>

                    <?php if($layout != 'full_layout'): ?>
                        <div class="col-lg-4 <?php echo e($layout == 'left_sidebar_layout' ? 'order-1' : 'order-2'); ?>">
                            <?php if ($__env->exists('theme/default::frontend.includes.sidebar.sidebar', [
                                'type' => 'home_page_sidebar',
                            ])) echo $__env->make('theme/default::frontend.includes.sidebar.sidebar', [
                                'type' => 'home_page_sidebar',
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('custom-js'); ?>
    <script src="<?php echo e(asset('/public/backend/assets/plugins/js-cookie/js.cookie.min.js')); ?>"></script>
    <?php
        $isPage = isset($page) ? 'true' : 'false';
        $visibility = $isPage == 'true' ? $page->visibility : 'false';
        $permalink = $isPage == 'true' ? $page->permalink : 'false';
    ?>
    <script>
        (function($) {
            'use strict';
            $(document).ready(function() {
                let isPage = '<?php echo $isPage; ?>';

                if (isPage == 'true') {
                    // if page is password protected then remove the contents
                    let visibility = '<?php echo $visibility; ?>';
                    let permalink = '<?php echo $permalink; ?>';

                    if (visibility == 'password') {
                        var page_details = $('#page_details').detach();
                    }

                    // checking if page cookie is available and getting it (For password protected page)
                    if (Cookies.get(permalink)) {
                        $('#password_box').remove();
                        $('#page_section').append(page_details);
                    }

                    // if the blog is password protected
                    $('#page_password').on('keypress', function(e) {
                        if (e.which === 13) {
                            var formData = $('#page_password_form').serializeArray();
                            $.ajax({
                                type: "post",
                                url: '<?php echo e(route('theme.default.page.password.load')); ?>',
                                data: formData,
                                success: function(res) {
                                    if (res.success) {
                                        $('#password_box').remove();
                                        $('#page_section').append(page_details);
                                        // Cookies expired on 1 day
                                        Cookies.set(permalink, JSON
                                            .stringify({
                                                page: permalink
                                            }), {
                                                expires: 1,
                                                path: '<?php echo e(env('APP_URL')); ?>'
                                            });
                                    } else {
                                        toastr.error(res.error,
                                            "<?php echo e(front_translate('Error!')); ?>");
                                    }
                                },
                                error: function(data, textStatus, jqXHR) {
                                    toastr.error("Content Request Failed",
                                        "<?php echo e(front_translate('Error!')); ?>");
                                }
                            });
                        }
                    });
                }
            })

            // Banner Slider Carousal Initialize
            let RTL = false;
            if ('<?php echo e($rtl); ?>') {
                RTL = true;
            }

            // Slider Banner Carousel
            let sync1 = $(".banner-slider");
            sync1
                .owlCarousel({
                    rtl: RTL,
                    items: 4,
                    slideSpeed: 2000,
                    autoplay: true,
                    loop: true,
                    responsiveRefreshRate: 200,
                    animateIn: false,
                    animateOut: false,
                    margin: 0,
                    responsive: {
                        0: {
                            items: 1
                        },
                        768: {
                            items: 2
                        },
                        1024: {
                            items: 3
                        },
                        1440: {
                            items: 4
                        }
                    }
                });

            // blog category change
            $(document).on('change', '#category_field', function() {
                let value = $('#category_field option:selected').val();
                if (value) {
                    let url = '<?php echo e(route('theme.default.blogByCategory', 'permalink')); ?>';
                    url = url.replace("permalink", value);
                    window.location.href = url;
                }
            });

        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('theme/default::frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/themes/default/resources/views/frontend/pages/home.blade.php ENDPATH**/ ?>