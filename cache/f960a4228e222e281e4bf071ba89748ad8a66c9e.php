<?php $__env->startSection('page_title', 'Workstations'); ?>
<?php $__env->startSection('page_content'); ?>

<form action="/workstations/update/<?php echo e($workstation['ID']); ?>" class="HFForm" method="post" data-na="success-then-do-nothing">
    <h5>Update Workstation</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="hostname">Host Name</label>
                        <input type="text" class="form-control" id="hostname" name="hostname" placeholder="Computer Name" autocomplete="off"  value="<?php echo e($workstation['hostname']); ?>">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="port">Port</label>
                        <input type="text" class="form-control" id="port" name="port" placeholder="Active Port" autocomplete="off" value="<?php echo e($workstation['port']); ?>" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" autocomplete="off" value="<?php echo e($workstation['description']); ?>" >
                    </div>

                    <div class="form-group">
                        <label>Group</label>
                        <select name="wsgroupid" id="wsgroupid" class="custom-select">
                            <?php if(!empty($groups)): ?>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php echo e(( $workstation['wsgroupid'] == $group['ID'] ? ' selected ' : '' )); ?> value="<?php echo e($group['ID']); ?>" ><?php echo e($group['group_name']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="isActive" name="isActive" <?php echo e(($workstation['isActive'] ? ' checked ' : '')); ?> >
                            <label for="isActive" class="custom-control-label">Workstation is active</label>
                        </div>
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
            <a href="/workstations" class="btn btn-flat hf-alt-btn">Cancel</a>
        </div>
    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/workstations/edit.blade.php ENDPATH**/ ?>