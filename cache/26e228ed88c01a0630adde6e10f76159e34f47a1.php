<?php $__env->startSection('page_title', 'Settings'); ?>
<?php $__env->startSection('page_content'); ?>

<div class="row">
    <div class="col col-md-6">

        <div class="card">
            <div class="card-body">
                <form action="/settings/update" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/settings">
                <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group">
                        <label for="<?php echo e($field['field']); ?>"><?php echo $field['label']; ?></label>
                        <input type="text" id="<?php echo e($field['field']); ?>" name="settings[<?php echo e($field['field']); ?>]" value="<?php echo e($field['value']); ?>" class="form-control" autocomplete="off">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php echo e(csrf()); ?>


                <div class="row">
                    <div class="col-sm-12">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>
    
            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/attendance-portal/views/cpanel/settings/show.blade.php ENDPATH**/ ?>