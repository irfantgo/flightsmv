<?php $__env->startSection('page_title', 'Recipients'); ?>
<?php $__env->startSection('page_content'); ?>


<?php echo $__env->make('cpanel.parts.page-controls', ['navigations' => ['/recipients/new' => 'New Recipient']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php if( empty($recipients) ): ?>
            <p>No recipients found</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $recipients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($data['full_name']); ?></td>
                        <td><?php echo e($data['email']); ?></td>
                        <td><?php echo ( $data['status'] ? ' <span class="text-green">Active</span> ' : '<span class="text-red">In-Active</span>' ); ?></td>
                        <td>
                            <a href="/recipients/edit/<?php echo e($data['ID']); ?>" class="btn btn-sm btn-primary btn-flat">Edit</a>
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
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-alerts/views/cpanel/recipients/show.blade.php ENDPATH**/ ?>