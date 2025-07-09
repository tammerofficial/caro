<?php if(!isset($data['link']) || (isset($data['link']) && $data['link'] == 'none')): ?>
    <img src="<?php echo e(asset(getFilePath($data['widget_image']))); ?>" alt="Image">
<?php else: ?>
    <a href="<?php echo e($data['link'] == 'media_file' ? asset(getFilePath($data['widget_image'])) : $data['link_url']); ?>"
        target="<?php echo e($data['link'] == 'custom_url' && $data['new_window'] == '1' ? '_blank' : '_self'); ?>">
        <img src="<?php echo e(asset(getFilePath($data['widget_image']))); ?>" alt="Image">
    </a>
<?php endif; ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/plugins/pagebuilder/views/builders/builder-widgets/image.blade.php ENDPATH**/ ?>