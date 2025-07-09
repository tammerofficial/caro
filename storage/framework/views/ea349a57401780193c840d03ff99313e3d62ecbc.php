<?php
$system_name = getGeneralSetting('system_name');
$desktop_logo = !empty(getGeneralSetting('admin_logo')) ? getFilePath(getGeneralSetting('admin_logo')) : '';
$login_bg_image = !empty(getGeneralSetting('login_bg_image')) ? getFilePath(getGeneralSetting('login_bg_image')) : '';
?>

<?php $__env->startSection('title'); ?>
<?php echo e(translate('Login')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_css'); ?>
<style>
    body {
        background-image: url('<?php echo e($login_bg_image); ?>');
        background-size: cover;
        position: relative;
        min-height: 100vh;
    }

    body:before {
        content: "";
        background-color: rgb(183 180 180 / 50%);
        top: 0;
        height: 100%;
        left: 0;
        width: 100%;
        position: absolute;
    }

    .login-page-layout {
        height: 100vh;
        min-height: 100%;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main_content'); ?>
<div class="container-fluid login-page-layout position-relative">
    <div class="align-items-center h-100 justify-content-center row py-5">
        <div class="col-xl-3 col-lg-4  col-12 mx-auto">
            <div class="card bg-white p-3 py-4">
                <div class="auth-card-header text-center pt-3">
                    <div class="logo">
                        <a href="/" class="default-logo">
                            <?php if(!empty($desktop_logo)): ?>
                            <img src="<?php echo e($desktop_logo); ?>" alt="TLCommerce Saas">
                            <?php else: ?>
                            <h3><?php echo e($system_name); ?></h3>
                            <?php endif; ?>
                        </a>
                    </div>
                    <h4 class="mt-3"><?php echo e(translate('Welcome Back')); ?></h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('core.attemptLogin')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <!-- Form Group -->
                        <div class="form-group mb-20">
                            <label for="email" class="mb-2 font-14 bold black"><?php echo e(translate('Email')); ?></label>
                            <input type="email" id="email" name="email" class="theme-input-style" placeholder="<?php echo e(translate('Email Address')); ?>" value="<?php echo e(old('email')); ?>">
                            <?php if($errors->has('email')): ?>
                            <div class="text-danger mt-2"><?php echo e($errors->first('email')); ?></div>
                            <?php endif; ?>
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div class="form-group mb-20">
                            <label for="password" class="mb-2 font-14 bold black"><?php echo e(translate('Password')); ?></label>
                            <input type="password" id="password" name="password" class="theme-input-style" placeholder="<?php echo e(translate('********')); ?>">
                            <?php if($errors->has('password')): ?>
                            <div class="text-danger mt-2"><?php echo e($errors->first('password')); ?></div>
                            <?php endif; ?>
                        </div>
                        <!-- End Form Group -->

                        <div class="d-flex justify-content-between mb-20">
                            <a href="<?php echo e(route('core.password.reset.link')); ?>" class="font-12 text_color"><?php echo e(translate('Forgot Password?')); ?></a>
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-block"><?php echo e(translate('Log In')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('core::base.auth.auth_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/Core/Views/base/auth/login.blade.php ENDPATH**/ ?>