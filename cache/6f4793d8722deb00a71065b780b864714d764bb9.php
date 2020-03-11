<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php $__currentLoopData = $navigations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if( isset($nav['permission']) ): ?>
                <?php if(\Heliumframework\Auth::hasPermission($nav['permission'])): ?>
                    <a href="<?php echo e($nav['link']); ?>" class="btn btn-default"><?php echo e($nav['label']); ?></a>
                <?php endif; ?>
            <?php else: ?> 
                <a href="<?php echo e($nav['link']); ?>" class="btn btn-default"><?php echo e($nav['label']); ?></a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div><?php /**PATH /Users/shan/www/tth/attendance-portal/views/cpanel/parts/auth-page-controls.blade.php ENDPATH**/ ?>