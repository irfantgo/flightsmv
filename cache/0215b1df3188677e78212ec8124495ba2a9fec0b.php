<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php $__currentLoopData = $navigations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($link); ?>" class="btn btn-default"><?php echo e($label); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div><?php /**PATH /Users/shan/www/flightsmv/views/cpanel/parts/page-controls.blade.php ENDPATH**/ ?>