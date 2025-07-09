<?php
    $feature_image = $data['feature_image'];
?>

<div class="single-feature box single-service style--six align-items-center media justify-content-center" id="feature">
    <?php if(!empty($feature_image)): ?>
        <div class="service-icon m-0">
            <img src="<?php echo e(asset(getFilePath($feature_image))); ?>" class="svg" alt="">
        </div>
    <?php endif; ?>
    <?php if(empty(!$data['feature_description_t_'])): ?>
        <div class="service-content media-body">
            <?php echo fix_image_urls($data['feature_description_t_']); ?>

        </div>
    <?php endif; ?>
</div>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/plugins/pagebuilder/views/builders/builder-widgets/feature.blade.php ENDPATH**/ ?>