<?php $__env->startSection('page_title', 'Departments'); ?>
<?php $__env->startSection('page_content'); ?>


<?php echo $__env->make('cpanel.parts.page-controls', ['navigations' => ['/departments/new' => 'New Department']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php if( empty($departments) ): ?>
            <p>No departments found</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($data['name']); ?></td>
                        <td><?php echo e($data['email']); ?></td>
                        <td>
                            <a href="/departments/edit/<?php echo e($data['ID']); ?>" class="btn btn-sm btn-primary btn-flat">Edit</a>
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
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-alerts/views/cpanel/departments/show.blade.php ENDPATH**/ ?>