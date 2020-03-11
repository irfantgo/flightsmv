<?php $__env->startSection('page_title', 'Departments'); ?>
<?php $__env->startSection('page_content'); ?>


<form action="/departments/patch/<?php echo e($department['ID']); ?>" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/departments/edit/<?php echo e($department['ID']); ?>">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Edit Recipient
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="full_name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Official name of the department" autocomplete="off" value="<?php echo e($department['name']); ?>" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Designated email for the department" autocomplete="off" value="<?php echo e($department['email']); ?>" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="attendance_view">Attendance View Name</label>
                        <input type="text" class="form-control" id="attendance_view" name="attendance_view" placeholder="Eg: dbo.example" autocomplete="off" value="<?php echo e($department['attendance_view']); ?>" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="schedule_view">Schedule View Name</label>
                        <input type="text" class="form-control" id="schedule_view" name="schedule_view" placeholder="Eg: dbo.example" autocomplete="off" value="<?php echo e($department['schedule_view']); ?>" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="isActive">
                            <input <?php echo e(( $department['isActive'] ? ' checked ' : '' )); ?> type="checkbox" id="isActive" name="isActive" value="1">
                            Department is Active</label>
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
            <a href="/departments" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/attendance-portal/views/cpanel/departments/edit.blade.php ENDPATH**/ ?>