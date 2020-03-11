<?php $__env->startSection('page_title', 'Cashiers'); ?>
<?php $__env->startSection('page_content'); ?>


<?php echo $__env->make('cpanel.parts.page-controls', ['navigations' => ['/cashiers/new' => 'New Cashier']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php if( empty($cashiers) ): ?>
            <p>No cashiers found</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cashiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($data['name']); ?></td>
                        <td><?php echo e($data['username']); ?></td>
                        <td><?php echo e($data['email']); ?></td>
                        <td><?php echo ( $data['isActive'] ? ' <span class="text-green">Account is Active</span> ' : '<span class="text-red">Account is In-Active</span>' ); ?></td>
                        <td>
                            <a href="/cashiers/edit/<?php echo e($data['ID']); ?>" class="btn btn-sm btn-primary btn-flat">Edit</a>
                            <a href="/cashiers/reset/<?php echo e($data['ID']); ?>" class="btn btn-sm btn-default btn-flat HFActionBtn" data-type="warning" data-title="Reset Pin Code" data-text="Are you sure you want to reset pin?" data-ns="/cashiers" >Reset Pin Code</a>
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
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/cashiers/show.blade.php ENDPATH**/ ?>