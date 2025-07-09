<?php
    $plans = getAllPlans();
    $plugins = availablePluginsForTenant();
    $payment_methods = getTenantPaymentGateways();
    $subscribe_btn_text = !empty($subscribe_btn_text) ? $subscribe_btn_text : 'Enroll Now';
?>

<?php $__currentLoopData = $free_packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $applicable_plugins = $package->plugins->toArray();
        $applicable_payment_methods = $package->payment_methods->toArray();
    ?>
    <div class="col-xl-4 col-md-6">
        <div class="price-box">
            <div class="price-head">
                <h3><?php echo e(translatePackageName($package->id)); ?></h3>
                <span class="align-items-baseline d-flex">
                    <strong><?php echo e(currencyExchange(0)); ?></strong>
                    <span class="d-inline-block">
                        <span class="ml-2"><?php echo e(front_translate('For Lifetime')); ?></span>
                    </span>
                </span>
            </div>
            <div class="price-body">
                <h5 class="mb-2"><?php echo e(front_translate('Applicable Features')); ?></h5>
                <ul class="list-unstyled mb-4">
                    <?php $__currentLoopData = $plugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($plugin->location != 'tlecommercecore'): ?>
                            <li>
                                <?php if(in_array($plugin->id, array_column($applicable_plugins, 'plugin_id'))): ?>
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                <?php else: ?>
                                    <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                <?php endif; ?>

                                <?php echo e(str_replace('Tlcommerce', '', $plugin->name)); ?>

                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <?php
                    $privileges = $package->privileges != null ? $package->privileges : null;
                ?>
                <?php if($privileges != null): ?>
                    <h5 class="mb-2"><?php echo e(front_translate('Access Privileges')); ?></h5>
                    <ul class="list-unstyled mb-4">
                        <?php $__currentLoopData = $privileges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $privilege = str_replace('package_privileges_', '', $key);
                                $privilege = ucwords(implode(' ', explode('_', $privilege)));
                            ?>
                            <li>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                <?php echo e($privilege); ?> - <?php echo e($value == -1 ? 'Unlimitted' : $value); ?>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>

                <h5 class="mb-2"><?php echo e(front_translate('Applicable Payment Methods')); ?></h5>
                <ul class="list-unstyled mb-4">
                    <?php $__currentLoopData = $payment_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method => $id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php if(in_array($id, array_column($applicable_payment_methods, 'payment_method'))): ?>
                                <i class="fa fa-check" aria-hidden="true"></i>
                            <?php else: ?>
                                <i class="fa fa-times text-danger" aria-hidden="true"></i>
                            <?php endif; ?>
                            <?php if($method == 'cod'): ?>
                                Cash On Delivery
                            <?php else: ?>
                                <?php echo e(ucfirst($method)); ?>

                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <div class="pricing-body-btn">
                    <a href="<?php echo e(route('plugin.saas.user.order.plan', ['package' => $package->id, 'plan' => $plan_id])); ?>"
                        class="btn-crs s-btn">
                        <?php echo e(front_translate($subscribe_btn_text)); ?>

                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $paid_packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $applicable_plugins = $package->plugins->toArray();
        $applicable_payment_methods = $package->payment_methods->toArray();
    ?>
    <div class="col-xl-4 col-md-6">
        <div class="price-box">
            <div class="price-head">
                <h3><?php echo e($package->name); ?></h3>
                <span class="align-items-baseline d-flex">
                    <strong><?php echo e(currencyExchange($package->cost)); ?></strong>
                    <?php if($package->plan_id != config('saas.plans.lifetime')): ?>
                        <span class="ml-2"> <?php echo e(front_translate('For')); ?> <?php echo e($package->duration); ?>

                            <?php echo e(front_translate('days')); ?></span>
                    <?php else: ?>
                        <span class="ml-2"><?php echo e(front_translate('For Lifetime')); ?></span>
                    <?php endif; ?>
                </span>
            </div>

            <div class="price-body">
                <h5 class="mb-2"><?php echo e(front_translate('Applicable Features')); ?></h5>
                <ul class="list-unstyled mb-4">
                    <?php $__currentLoopData = $plugins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($plugin->location != 'tlecommercecore'): ?>
                            <li>
                                <?php if(in_array($plugin->id, array_column($applicable_plugins, 'plugin_id'))): ?>
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                <?php else: ?>
                                    <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                <?php endif; ?>

                                <?php echo e(str_replace('Tlcommerce', '', $plugin->name)); ?>

                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <?php
                    $privileges = $package->privileges != null ? json_decode($package->privileges, true) : null;
                ?>
                <?php if($privileges != null): ?>
                    <h5 class="mb-2"><?php echo e(front_translate('Access Privileges')); ?></h5>
                    <ul class="list-unstyled mb-4">
                        <?php $__currentLoopData = $privileges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $privilege = str_replace('package_privileges_', '', $key);
                                $privilege = ucwords(implode(' ', explode('_', $privilege)));
                            ?>
                            <li>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                <?php echo e($privilege); ?> - <?php echo e($value == -1 ? 'Unlimitted' : $value); ?>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>

                <h5 class="mb-2"><?php echo e(front_translate('Applicable Payment Methods')); ?></h5>
                <ul class="list-unstyled mb-4">
                    <?php $__currentLoopData = $payment_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method => $id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php if(in_array($id, array_column($applicable_payment_methods, 'payment_method'))): ?>
                                <i class="fa fa-check" aria-hidden="true"></i>
                            <?php else: ?>
                                <i class="fa fa-times text-danger" aria-hidden="true"></i>
                            <?php endif; ?>
                            <?php if($method == 'cod'): ?>
                                Cash On Delivery
                            <?php else: ?>
                                <?php echo e(ucfirst($method)); ?>

                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <div class="align-items-center d-flex justify-content-between pricing-body-btn">
                    <a href="<?php echo e(route('plugin.saas.user.order.plan', ['package' => $package->id, 'plan' => $package->plan_id])); ?>"
                        class="btn-crs s-btn">
                        <?php echo e(front_translate($subscribe_btn_text)); ?>

                    </a>
                    <?php if($package->trail_period > 0): ?>
                        <a href="<?php echo e(route('plugin.saas.user.order.plan', ['package' => $package->id, 'plan' => $package->plan_id, 'is_trial' => 1])); ?>"
                            class="btn-link ml-2">
                            Get <?php echo e($package->trail_period); ?> Days Trial
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/plugins/pagebuilder/views/builders/builder-widgets/include/package_list.blade.php ENDPATH**/ ?>