<?php
    $verticalSlide = 1;
    $horizontalSlide = 1;
    $total_slide = 1;
    $slideBlog = true;
?>
<div class="widget-content">
    <?php if($slideBlog): ?>
        <!-- Post Carousel -->
        <div class="wmcp-cover owl-carousel" data-owl-mouse-drag="true" data-owl-dots="true" data-owl-margin="20"
            data-owl-items="2">
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- Single Testimolial -->
                <div class="testimonial-single style--two plug">
                    <div class="ts-top d-flex align-items-center">
                        <div class="tst-content media align-items-center">
                            <div class="ts-img m-0">
                                <img src="<?php echo e($review['reviewer_image']['path']); ?>" data-rjs="2" alt="">
                            </div>
                            <div class="content media-body">
                                <?php if((float) $review['rating'] >= 5): ?>
                                    <!-- Ratings -->
                                    <div class="star-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <!-- Ratings -->
                                <?php elseif(strpos($review['rating'], '.')): ?>
                                    <?php for($i = 0; $i < (int) $review['rating']; $i++): ?>
                                        <i class="fa fa-star"></i>
                                    <?php endfor; ?>
                                    <i class="fa fa-star-half-o"></i>
                                <?php else: ?>
                                    <?php for($i = 0; $i < (int) $review['rating']; $i++): ?>
                                        <i class="fa fa-star"></i>
                                    <?php endfor; ?>
                                <?php endif; ?>
                                <h5><?php echo e($review['reviewer_name']); ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="ts-bottom">
                        <p><?php echo e($review['comment']); ?></p>
                    </div>
                </div>
                <!-- End Single Testimolial -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <!-- End of Post Carousel -->
    <?php endif; ?>
</div>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/caro/plugins/pagebuilder/views/builders/builder-widgets/review.blade.php ENDPATH**/ ?>