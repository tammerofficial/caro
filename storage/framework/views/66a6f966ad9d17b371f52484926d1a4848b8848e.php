<ul class="<?php echo e($list); ?> <?php echo e(isset($column) ? $column : ''); ?>">
    <?php $__currentLoopData = $main_menuTree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="<?php echo e(!empty($menuItem->children) ? 'menu-item-has-children' : ''); ?>">
            <a href="<?php echo e($menuItem->preview_url); ?>"
                class="single-header-menu <?php echo e(getActiveMenuColor($menuItem->index, $data)); ?>">
                <?php echo e($menuItem->title); ?>

                <?php if(!empty($menuItem->children) && !isset($column)): ?>
                    <img class="svg ml-10"
                        src="<?php echo e(asset('themes/newslooks/public/')); ?>/img/icon/angle-<?php echo e($menuItem->level > 1 ? 'right' : 'down'); ?>.svg"
                        alt="">
                <?php endif; ?>
            </a>
            <?php if(!empty($menuItem->children)): ?>
                <?php echo $__env->make('theme/default::frontend.includes.menu', [
                    'main_menuTree' => $menuItem->children,
                    'list' => 'sub-menu',
                    'data' => $data,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if($list != 'sub-menu'): ?>
        <?php if($contact_header): ?>
            <li class="">
                <a class="" href="<?php echo e(url('/contact')); ?>"><?php echo e($contact_text); ?></a>
            </li>
        <?php endif; ?>
        <li class="d-flex header-menu-btn-group">
            <!-- Header Button -->
            <?php if(auth()->guard()->check()): ?>
                <div class="header-btn book">
                    <?php if(sizeOf($header) > 0): ?>
                        <?php if(!empty($header['dash_button_text'])): ?>
                            <a href="<?php echo e(route('plugin.saas.user.dashboard')); ?>"
                                class="btn-crs plug dash"><?php echo e(front_translate($header['dash_button_text'])); ?></a>
                        <?php else: ?>
                            <a href="<?php echo e(route('plugin.saas.user.dashboard')); ?>"
                                class="btn-crs plug dash"><?php echo e(front_translate('Dashboard')); ?></a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('plugin.saas.user.dashboard')); ?>"
                            class="btn-crs plug dash"><?php echo e(front_translate('Dashboard')); ?></a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="header-btn book">
                    <?php if(sizeOf($header) > 0): ?>
                        <?php if(!empty($header['login_button_text'])): ?>
                            <a href="<?php echo e(route('subscriber.login')); ?>"
                                class="btn-crs plug login"><?php echo e(front_translate($header['login_button_text'])); ?></a>
                        <?php else: ?>
                            <a href="<?php echo e(route('subscriber.login')); ?>"
                                class="btn-crs plug login"><?php echo e(front_translate('Login')); ?></a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('subscriber.login')); ?>"
                            class="btn-crs plug login"><?php echo e(front_translate('Login')); ?></a>
                    <?php endif; ?>
                </div>
                <div class="header-btn book">
                    <?php if(sizeOf($header) > 0): ?>
                        <?php if(!empty($header['registratiion_button_text'])): ?>
                            <a href="<?php echo e(route('plugin.saas.user.registration')); ?>"
                                class="btn-crs plug reg"><?php echo e(front_translate($header['registratiion_button_text'])); ?></a>
                        <?php else: ?>
                            <a href="<?php echo e(route('plugin.saas.user.registration')); ?>"
                                class="btn-crs plug reg"><?php echo e(front_translate('sign up')); ?></a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('plugin.saas.user.registration')); ?>"
                            class="btn-crs plug reg"><?php echo e(front_translate('sign up')); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>


            <?php if(!empty($header['language_option'])): ?>
                <div class="header-btn book">
                    <select class="bg-light py-1 px-2 form-control-lg language-change">
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($language->code); ?>" <?php if($language->code == getFrontLocale()): echo 'selected'; endif; ?> class="form-control">
                                <?php echo e($language->native_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            <?php endif; ?>
            <!-- End Header Button -->
        </li>
    <?php endif; ?>
</ul>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/themes/default/resources/views/frontend/includes/menu.blade.php ENDPATH**/ ?>