<?php if( !empty(\Heliumframework\Notifications::get()) ): ?>
    <?php $__currentLoopData = \Heliumframework\Notifications::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert <?php echo e($msg->type); ?> alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            
            <?php echo e($msg->msg); ?>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo e(\Heliumframework\Notifications::clear()); ?>

<?php endif; ?><?php /**PATH /Users/shan/www/tth/attendance-portal/views/cpanel/parts/alerts.blade.php ENDPATH**/ ?>