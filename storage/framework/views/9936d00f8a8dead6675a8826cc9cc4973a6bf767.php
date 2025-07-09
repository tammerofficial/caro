<?php
    $url = isset($data['button_url']) ? $data['button_url'] : '#';
    $target = isset($data['new_window']) && $data['new_window'] == 1 ? '_blank' : '_self';
    $text = isset($data['button_text_t_']) ? $data['button_text_t_'] : '';
    $justify = isset($data['alignment']) && $data['alignment'] == 'justify' ? 'd-block' :'';
?>

<a href="<?php echo e($url); ?>" target="<?php echo e($target); ?>" class="btn-crs btn-cta text-center <?php echo e($justify); ?>"><?php echo e($text); ?></a><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/plugins/pagebuilder/views/builders/builder-widgets/button.blade.php ENDPATH**/ ?>