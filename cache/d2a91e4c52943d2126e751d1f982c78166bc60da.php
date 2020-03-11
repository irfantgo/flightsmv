


<?php echo $__env->make('cpanel.alerts.callouts', ['callout_type' => 'info', 'callout_title' => 'Query', 'callout_message' => $query], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(!empty($errors)): ?>
    <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p><?php echo e($error); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>

    <?php if(empty($results['rows'])): ?>
        <?php echo $__env->make('cpanel.alerts.callouts', ['callout_type' => 'warning', 'callout_title' => 'Results', 'callout_message' => $results['message']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        
        <?php
            print_r($results)
        ?>

    <?php endif; ?>
    
<?php endif; ?>

<?php /**PATH /Users/shan/www/tth/tth-alerts/views/cpanel/vesalius/query-results.blade.php ENDPATH**/ ?>