<?php if(count($page_sections)): ?>
    <?php $__currentLoopData = $page_sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $section_prop = !empty($section['properties']['properties']) ? $section['properties']['properties'] : false;
            $container = isset($section_prop['container']) ? $section_prop['container'] : 'container';
            $vertical = isset($section_prop['vertical']) ? $section_prop['vertical'] : 'start';
        ?>
        <section class="pt-10 pb-10" id="section_<?php echo e($section['id'] . '_' . $section['page_id']); ?>">
            <div class="<?php echo e($container); ?>">
                <div class="row align-items-<?php echo e($vertical); ?>">

                    <?php $__currentLoopData = $section['layouts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section_layouts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-<?php echo e($section_layouts['col_value']); ?>">

                            <?php $__currentLoopData = $section_layouts['layout_widgets']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $layout_widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $properties = !empty($layout_widget['properties']['properties']) ? $layout_widget['properties']['properties'] : false;
                                    $alignment = isset($properties['alignment']) ? $properties['alignment'] : 'start';
                                    $widget_name = $layout_widget['widget']['name'];

                                    switch ($widget_name) {
                                        case 'author':
                                            $widget_specific_class = 'widget-about';
                                            break;

                                        case 'tag':
                                            $widget_specific_class = 'widget-tag-cloud';
                                            break;

                                        case 'list_blog':
                                            $widget_specific_class = 'widget-recent-post';
                                            break;

                                        case 'title_overlay_blog':
                                            $widget_specific_class = 'widget-featured-post';
                                            break;

                                        case 'slider_blog':
                                            $widget_specific_class = 'widget-most-commented-post';
                                            break;

                                        case 'review':
                                            $widget_specific_class = 'widget-most-commented-post';
                                            break;

                                        default:
                                            $widget_specific_class = '';
                                            break;
                                    }
                                ?>

                                <div class="widget w-100 text-<?php echo e($alignment); ?> <?php echo e($widget_specific_class); ?> shadow-none"
                                    id="section_<?php echo e($section['id'] . '_widget_' . $layout_widget['id']); ?>">

                                    <?php if($properties): ?>
                                        <?php if ($__env->exists(
                                            'plugin/pagebuilder::builders.builder-widgets.' . $widget_name,
                                            [
                                                'data' => $properties,
                                            ]
                                        )) echo $__env->make(
                                            'plugin/pagebuilder::builders.builder-widgets.' . $widget_name,
                                            [
                                                'data' => $properties,
                                            ]
                                        , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/plugins/pagebuilder/views/builders/builder-section.blade.php ENDPATH**/ ?>