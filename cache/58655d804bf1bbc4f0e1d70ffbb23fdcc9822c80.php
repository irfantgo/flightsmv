<?php $__env->startSection('page_title', 'Workstation Groups'); ?>
<?php $__env->startSection('page_content'); ?>

<form action="/wsgroups/update/<?php echo e($group['ID']); ?>" class="HFForm" method="post" data-na="success-then-do-nothing">
    <h5>Update Workstation</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-body">

                    <div class="form-group">
                        <label class="col-form-label" for="group_name">Group Name</label>
                        <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Group Name" autocomplete="off"  value="<?php echo e($group['group_name']); ?>">
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <?php echo e(csrf()); ?>


    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Edit</button>
            <a href="/wsgroups" class="btn btn-flat hf-alt-btn">Cancel</a>
        </div>
    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/wsgroups/edit.blade.php ENDPATH**/ ?>