<?php $__env->startSection('page_title', 'Users'); ?>
<?php $__env->startSection('page_content'); ?>


<?php echo $__env->make('cpanel.parts.page-controls', ['navigations' => [
    [
        'url' => '/admin/users/new',
        'label' => 'New User',
        'isPrimary' => true
    ]
]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php if( empty($users) ): ?>
            <p>No users found</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Verified</th>
                        <th>Account Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($data['display_name']); ?></td>
                        <td><?php echo e($data['username']); ?></td>
                        <td><?php echo e($data['email']); ?></td>
                        <td><?php echo ( $data['isVerified'] ? ' <span class="text-green">Verified</span> ' : '<span class="text-red">Pending Verification</span>' ); ?></td>
                        <td><?php echo ( $data['isActive'] ? ' <span class="text-green">Account is Active</span> ' : '<span class="text-red">Account is In-Active</span>' ); ?></td>
                        <td>
                            <a href="/admin/users/edit/<?php echo e($data['uid']); ?>" class="btn btn-sm btn-primary btn-flat">Edit</a>
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
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/flightsmv/views/cpanel/users/show.blade.php ENDPATH**/ ?>