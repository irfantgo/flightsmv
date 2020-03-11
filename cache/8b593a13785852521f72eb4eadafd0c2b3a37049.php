<?php $__env->startSection('page_title', 'Documents'); ?>
<?php $__env->startSection('page_content'); ?>


<?php echo $__env->make('cpanel.attendance.controls', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if( empty($documents) ): ?>
    <?php echo $__env->make('cpanel.alerts.callouts', ['callout_title' => 'No Documents Found', 'callout_message' => 'There are no reports for this department', 'callout_type' => 'info'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
    <div class="card card-default color-palette-box">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Document Name</th>
                        <th width="20%">Created On</th>
                        <th width="25%">Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($data['doc_name']); ?></td>
                        <td><?php echo e(date('d F Y \a\t h:iA', strtotime($data['created_dt']))); ?></td>
                        <td><?php echo ( $data['acknowledged'] ? ' <span class="text-green">Acknowledged by '.$data['ack_display_name'].'</span> <br><small>on '.date('d F Y \a\t h:iA', strtotime($data['acknowledged_dt'])).'</small> </span> ' : '<span class="text-red">Waiting for acknowledgement' ); ?></td>
                        <td>
                            <a target="_blank" href="/department/documents-view/<?php echo e($data['ID']); ?>" class="btn btn-sm btn-default btn-flat">View Report</a>
                            <?php if($data['acknowledged'] == false): ?>
                                <a href="/department/document-ack/<?php echo e($data['ID']); ?>" class="btn btn-sm btn-primary btn-flat HFActionBtn" data-title="Acknowledgement" data-text="Are you sure you want to continue? You cannot undo this action." data-type="warning" data-ns="/department/documents/<?php echo e($department['ID']); ?>">Acknowledge</a>
                            <?php endif; ?>
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
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/attendance-portal/views/cpanel/attendance/documents.blade.php ENDPATH**/ ?>