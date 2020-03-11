<?php $__env->startSection('page_title', 'Workstations'); ?>
<?php $__env->startSection('page_content'); ?>


<?php echo $__env->make('cpanel.parts.page-controls', ['navigations' => [
    '/workstations/new' => 'New Workstation', 
    '/wsgroups' => 'Workstation Groups'
]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php if( empty($workstations) ): ?>
            <p>No workstation found</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Hostname</th>
                        <th>Active Port</th>
                        <th>Description</th>
                        <th>Group Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $workstations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($data['hostname']); ?></td>
                        <td><?php echo e($data['port']); ?></td>
                        <td><?php echo e($data['description']); ?></td>
                        <td><?php echo e($data['group_name']); ?></td>
                        <td><?php echo ( $data['isActive'] ? ' <span class="text-green">Active</span> ' : '<span class="text-red">In-Active</span>' ); ?></td>
                        <td>
                            <a href="/workstations/edit/<?php echo e($data['ID']); ?>" class="btn btn-sm btn-primary btn-flat">Edit</a>
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
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/workstations/show.blade.php ENDPATH**/ ?>