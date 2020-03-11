<?php $__env->startSection('page_title', 'Groups'); ?>
<?php $__env->startSection('page_content'); ?>


<form action="/groups/store" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/groups">
    <h5>Create New Group</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="group_name">Group Name</label>
                        <input type="text" class="form-control" id="group_name" name="group_name" placeholder="" autocomplete="off" >
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Group Roles
                </div>
                <div class="card-body">
                    
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="roles[]" value="<?php echo e($role['code']); ?>" id="r_<?php echo e($role['code']); ?>">
                                <label for="r_<?php echo e($role['code']); ?>"><?php echo e($role['description']); ?></label>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <?php echo e(csrf()); ?>


    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Create</button>
            <a href="/groups" class="btn btn-flat hf-alt-btn">Cancel</a>
        </div>
    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/attendance-portal/views/cpanel/groups/create.blade.php ENDPATH**/ ?>