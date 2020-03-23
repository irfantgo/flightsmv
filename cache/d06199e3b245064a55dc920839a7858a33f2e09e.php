<?php if( empty($flights) ): ?>
    <p>No flights found</p>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="2">Airline</th>
                <th>Flight No</th>
                <th>Scheduled Date</th>
                <th>Scheduled Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $flights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td width="120"><img src="<?php echo e($data['airline_img']); ?>" alt="<?php echo e($data['airline_id']); ?>"></td>
                <td><?php echo e($data['airline_name']); ?> <br> <small><?php echo e($data['airline_id']); ?></small></td>
                <td><?php echo e($data['flight_no']); ?></td>
                <td><?php echo e(date('d F Y', strtotime($data['scheduled_d']))); ?></td>
                <td><?php echo e(date('H:i', strtotime($data['scheduled_t']))); ?></td>
                <td>
                    <span class="<?php echo e($data['status_flag']); ?>">
                        <?php echo e($data['flight_status']); ?>

                    </span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?><?php /**PATH /Users/shan/www/flightsmv/views/cpanel/flights/info.blade.php ENDPATH**/ ?>