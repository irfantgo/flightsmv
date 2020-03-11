<?php $__env->startSection('page_title', $department['name']); ?>
<?php $__env->startSection('page_content'); ?>


<?php echo $__env->make('cpanel.attendance.controls', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if($status == false): ?>
        <?php echo $__env->make('cpanel.alerts.callouts', ['callout_type' => 'warning', 'callout_title' => 'An error occured', 'callout_message' => $message], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>

        <?php 
            $prevmonth = date('F', strtotime('last month'));
            $currmonth = date('F', strtotime('this month'));
        ?>
        <h4>Attendance - <?php echo $prevmonth; ?> 15th to <?php echo $currmonth; ?> 15th  </h4>

        <div class="card">
            <div class="card-header">
                SQL DUMP
            </div>
            <div class="card-body">
                <?php while($row = $results): ?> 
                    <pre>
                        <?php
                            print_r($row)
                        ?>
                    </pre>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                A bit cleaner version
            </div>
            <div class="card-body">
                <pre>
                <?php
                    print_r($dataset)
                ?>
                </pre>
            </div>
        </div>

    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/attendance-portal/views/cpanel/attendance/debug.blade.php ENDPATH**/ ?>