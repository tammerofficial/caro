<?php $__env->startSection('title'); ?>
    Not Found
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-xl-12 text-center">
        <h1 class="my-4 title">404 | Page Not Found</h1>
        <div class="image-wrapper">
            <img src="<?php echo e(asset('public/errors/404.png')); ?>" alt="404">
        </div>
        <div class="pt-5 mt-2">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="details-btn">
                Back To Home <i class="icofont-arrow-right"></i>
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.error-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/resources/views/errors/404.blade.php ENDPATH**/ ?>