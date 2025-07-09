<?php
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
?>
<!-- Footer -->
<footer class="footer footer-container plugin-footer text-white pt-4">
    <div class="footer-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-5 col-sm-10 col-12">
                    <!-- Widget Text -->
                    <div class="widget widget_text">
                        <?php if($is_logo && $footer_logo != null): ?>
                            <?php
                                if (!str_contains($logo_url, 'https://') || !str_contains($logo_url, 'http://')) {
                                    $logo_url = 'http://' . $logo_url;
                                }
                            ?>
                            <a href="<?php echo e($logo_url); ?>"><img src="<?php echo e($footer_logo); ?>" alt="logo"
                                    class="img-fluid"></a>
                        <?php else: ?>
                            <h2 class="footer-logo"><?php echo e($text_logo); ?></h2>
                        <?php endif; ?>

                        <?php if(!empty($footer['footer_content'])): ?>
                            <p class="mt-3">
                                <?php echo e(front_translate($footer['footer_content'])); ?>

                            </p>
                        <?php endif; ?>

                        <div class="social-icon plug footer-social">
                            <?php if($is_social): ?>
                                <?php if(isset($all_socials)): ?>
                                    <?php $__currentLoopData = $all_socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($social->social_icon != ''): ?>
                                            <?php
                                                $logo_url = $social->social_icon_url;
                                                if (
                                                    $social->social_icon_url === '' ||
                                                    $social->social_icon_url === '/'
                                                ) {
                                                    $logo_url = url('/') . $social->social_icon_url;
                                                }
                                            ?>
                                            <a href="<?php echo e($logo_url); ?>" aria-label="icon"><i
                                                    class="fa <?php echo e($social->social_icon); ?>"></i></a>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- End Widget Text -->
                </div>

                <?php if(!empty($footer_left_menu)): ?>
                    <div class="col-lg-2 col-md-5 col-sm-10 col-12">
                        <!-- Footer Menu -->
                        <div class="widget widget_footer_menu">
                            <!-- Widget Title -->
                            <div class="widget_title">
                                <?php if(sizeOf($footer_left_menu) > 0): ?>
                                    <h3 class="custom-title-style"><?php echo e($footer_left_menu[0]->group_name); ?></h3>
                                <?php endif; ?>
                            </div>
                            <!-- End Widget Title -->

                            <div class="footer_menu plug">
                                <ul>
                                    <?php $__currentLoopData = $footer_left_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e($menu->url); ?>"><?php echo e($menu->title); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                        <!-- End Footer Menu -->
                    </div>
                <?php endif; ?>
                <?php if(!empty($footer_left_menu)): ?>
                    <div class="col-lg-2 col-md-5 col-sm-10 col-12">
                        <!-- Footer Menu -->
                        <div class="widget widget_footer_menu">
                            <!-- Widget Title -->
                            <div class="widget_title">
                                <?php if(sizeOf($footer_right_menu) > 0): ?>
                                    <h3 class="custom-title-style"><?php echo e($footer_right_menu[0]->group_name); ?></h3>
                                <?php endif; ?>
                            </div>
                            <!-- End Widget Title -->

                            <div class="footer_menu plug">
                                <ul>
                                    <?php $__currentLoopData = $footer_right_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e($menu->url); ?>"><?php echo e($menu->title); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                        <!-- End Footer Menu -->
                    </div>
                <?php endif; ?>

                <?php if(!empty($subscribe['footer_subscribe_form'])): ?>
                    <div class="col-lg-4 col-md-5 col-sm-10 col-12">
                        <div class="widget widget_newsletter footerNewsletter newsletter-cover">
                            <div class="widget_title">
                                <?php if(!empty($subscribe['subscribe_form_title'])): ?>
                                    <h3><?php echo e(front_translate($subscribe['subscribe_form_title'])); ?></h3>
                                <?php endif; ?>
                            </div>

                            <form action="javascript:void(0);" method="post" class="newsletterForm">
                                <?php echo csrf_field(); ?>
                                <div class="theme-input-group pay plug">
                                    <input class="theme-input-style" type="email" name="email"
                                        placeholder="<?php echo e(!empty($subscribe['subscribe_form_placeholder']) ? front_translate($subscribe['subscribe_form_placeholder']) : ''); ?>">
                                    <?php if($is_privacy): ?>
                                        <div class="m-0 d-flex mb-3 footer-checkbox-cover">
                                            <?php
                                                $tlpage = Core\Models\TlPage::where(
                                                    'id',
                                                    $subscribe['privacy_policy_page'],
                                                )
                                                    ->select(['id', 'permalink', 'title'])
                                                    ->first();
                                                $parentUrl = isset($tlpage) ? getParentUrl($tlpage) : '';
                                            ?>
                                            <input type="checkbox" class="mb-0 nl-checkbox">
                                            <p>
                                                <?php echo e(front_translate("I've read and accept the")); ?>

                                                <?php if($tlpage != null): ?>
                                                    <a class="font-weight-bold"
                                                        href="<?php echo e(route('theme.default.viewPage', ['permalink' => $parentUrl . $tlpage->permalink])); ?>">
                                                        <?php echo e($tlpage->translation('title', getFrontLocale())); ?>

                                                    </a>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                    <button type="submit" class="btn">
                                        <?php echo e(!empty($subscribe['subscribe_form_button_text']) ? front_translate($subscribe['subscribe_form_button_text']) : ''); ?>

                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if($is_text): ?>
        <div class="justify-content-center mt-5 copyright">
            <div class="col-12">
                <div class="footer-cradit text-center">
                    <?php echo xss_clean($footer_copyright_text); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>

</footer>
<!-- End Footer -->
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/themes/default/resources/views/frontend/layout/footer.blade.php ENDPATH**/ ?>