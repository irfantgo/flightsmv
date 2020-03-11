<?php $__env->startSection('page_title', 'Dashboard'); ?>
<?php $__env->startSection('page_content'); ?>

    <div class="row">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?php echo e($recipients); ?></h3>
                    <p>Recipients</p>
                </div>
                <div class="icon"><i class="ion ion-bag"></i></div>
                <a href="/recipients" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?php echo e($departments); ?></h3>
                    <p>Departments</p>
                </div>
                <div class="icon"><i class="ion ion-stats-bars"></i></div>
                    <a href="/departments" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?php echo e($users); ?></h3>
                    <p>Users</p>
                </div>
                <div class="icon"><i class="ion ion-person-add"></i></div>
                    <a href="/users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
        </div>
        <!-- ./col -->
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-alerts/views/cpanel/dashboard/show.blade.php ENDPATH**/ ?>