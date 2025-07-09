<?php
    $package_repository = new \Plugin\Saas\Repositories\PackageRepository();
    $package_plans = $package_repository->getActivePackagePlans();
    $first_plan = sizeOf($package_plans) > 0 ? $package_plans[0]->id : -1;
    $subscribe_btn_text = $data['subscribe_btn_text_t_'];
?>
<!-- Pricing Table 5 -->
<section class="pb-110 overflow-hidden" id="pricing">
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-center pb-40 pricing-tab-btn flex-wrap">
                    <?php $__currentLoopData = $package_plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button class="btn pricing-plan-btn package-plan" id="<?php echo e(strtolower($plan->id)); ?>"
                            onclick="getPackagesAccordingToPlan('<?php echo e($plan->id); ?>')">
                            <?php echo e(front_translate($plan->name)); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" id="packages">

        </div>
    </div>
</section>
<!-- End Pricing Table 5 -->

<?php $__env->startSection('custom-js'); ?>
    <script>
        $(document).ready(function() {
            'use strict'
            getPackagesAccordingToPlan('<?php echo e($first_plan); ?>')
        });

        /**
         * Get all packages according to selected plan
         */
        function getPackagesAccordingToPlan(plan_id) {
            'use strict'
            $('#pricing').addClass('disabled-section')
            $.post("<?php echo e(route('plugin.saas.get.packages.according.to.plan.frontend')); ?>", {
                    _token: '<?php echo e(csrf_token()); ?>',
                    plan_id: plan_id,
                    is_for_payment: 1,
                    subscribe_btn_text: '<?php echo e($subscribe_btn_text); ?>'
                })
                .done(function(data) {
                    $('#packages').html(data)
                    $('.package-plan').removeClass('active')
                    $('#' + plan_id).addClass('active')
                    $('#pricing').removeClass('disabled-section')
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    $('#pricing').removeClass('disabled-section');
                });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/plugins/pagebuilder/views/builders/builder-widgets/pricing.blade.php ENDPATH**/ ?>