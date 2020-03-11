<?php $__env->startSection('page_title', 'Vesalius Reports'); ?>
<?php $__env->startSection('page_content'); ?>


<?php echo $__env->make('cpanel.parts.page-controls', ['navigations' => ['/reports-ves/new' => 'New Report']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php if( empty($queries) ): ?>
            <p>No queries found</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Run Time (24hrs)</th>
                        <th>Recurrance</th>
                        <th>Created By</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $queries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($data['title']); ?> <br> <small><?php echo e($data['description']); ?></small></td>
                        <td><?php echo e(date("H:i", strtotime($data['run_t']))); ?></td>
                        <td><?php echo e($data['rec']); ?></td>
                        <td><?php echo e($data['created_by']); ?></td>
                        <td>
                            <a href="/reports-ves/edit/<?php echo e($data['ID']); ?>" class="btn-flat">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                    
            </table>
        <?php endif; ?>
    </div>
    <!-- /.card-body -->
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-alerts/views/cpanel/vesalius/show.blade.php ENDPATH**/ ?>