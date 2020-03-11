<?php $__env->startSection('page_title', 'Applications'); ?>
<?php $__env->startSection('page_content'); ?>


<?php echo $__env->make('cpanel.parts.page-controls', [
    'navigations' => [
                        '/applications/new' => 'New Application',
                        '/applications/help' => 'Help'
                    ]
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php if( empty($applications) ): ?>
            <p>No applications found</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Access Token</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($data['app_name']); ?></td>
                        <td><code><?php echo e($data['token']); ?></code></td>
                        <td>
                            <a href="/applications/revoke/<?php echo e($data['ID']); ?>" class="btn btn-sm btn-danger btn-flat HFActionBtn" data-type="warning" data-title="Revoke Application" data-text="Are you sure you want to revoke this application?" data-ns="/applications" >Revoke</a>
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
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/applications/show.blade.php ENDPATH**/ ?>