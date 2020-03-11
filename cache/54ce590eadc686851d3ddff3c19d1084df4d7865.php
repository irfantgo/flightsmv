<?php $__env->startSection('page_title', 'Queries'); ?>

<?php $__env->startSection('page_content'); ?>
<?php echo $__env->make('cpanel.queries.controls', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="container">

<?php if( empty($queries) ): ?> 
    <?php echo $__env->make('cpanel.alerts.data-not-found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>

    <table class="table">
        <tr>
            <th>Title</th>
            <th>Run Time (24hrs)</th>
            <th>Recurrance</th>
            <th>Created By</th>
            <th></th>
        </tr>
        <?php $__currentLoopData = $queries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($data['title']); ?> <br> <small><?php echo e($data['description']); ?></small></td>
                <td><?php echo e(date("H:i", strtotime($data['run_t']))); ?></td>
                <td><?php echo e($data['rec']); ?></td>
                <td><?php echo e($data['created_by']); ?></td>
                <td>
                    <a href="/queries/edit/<?php echo e($data['ID']); ?>" class="btn-flat">Edit</a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </table>

<?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-alerts/views/cpanel/queries/show.blade.php ENDPATH**/ ?>