<?php $__env->startSection('page_title', 'Applications'); ?>
<?php $__env->startSection('page_content'); ?>


<form action="/applications/create" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/applications">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    New Application
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="app_name">Application Name</label>
                        <input type="text" class="form-control" id="app_name" name="app_name" placeholder="Application Name" autocomplete="off" >
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <?php echo $__env->make('cpanel.alerts.callouts', ['callout_type' => 'info', 'callout_title' => 'Please note the following', 'callout_message' => '<p>Application token will be auto generated</p>'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo e(csrf()); ?>


    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Create</button>
            <a href="/applications" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/applications/create.blade.php ENDPATH**/ ?>