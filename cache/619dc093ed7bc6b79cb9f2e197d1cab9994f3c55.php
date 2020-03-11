<?php $__env->startSection('page_title', 'Workstations'); ?>
<?php $__env->startSection('page_content'); ?>


<form action="/workstations/create" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/workstations">
    <h5>Create New Workstation</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="hostname">Host Name</label>
                        <input type="text" class="form-control" id="hostname" name="hostname" placeholder="Computer Name" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="port">Port</label>
                        <input type="text" class="form-control" id="port" name="port" placeholder="Active Port" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label>Group</label>
                        <select name="wsgroupid" id="wsgroupid" class="custom-select">
                            <?php if(!empty($groups)): ?>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($group['ID']); ?>" ><?php echo e($group['group_name']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <?php echo e(csrf()); ?>


    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Create</button>
            <a href="/workstations" class="btn btn-flat hf-alt-btn">Cancel</a>
        </div>
    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/workstations/create.blade.php ENDPATH**/ ?>