<?php $__env->startSection('page_title', 'Users'); ?>
<?php $__env->startSection('page_content'); ?>


<form action="/users/create" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/users">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Create New User
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter staff full name" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Active Directory Username" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="group_id">Group</label>
                        <select name="group_id" id="group_id" class="form-control select2">
                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($group['ID']); ?>"><?php echo e($group['group_name']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    User Departments
                </div>
                <div class="card-body" style="min-height: 400px; overflow: scroll;">

                    <?php if( empty($departments) ): ?>
                        <p>No Departments Found</p>
                    <?php else: ?>    
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-handshake"></th>
                                    <th><i class="fas fa-envelope-open-text"></th>
                                    <th>Department Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td width="10%"><input type="checkbox" id="dept-<?php echo e($i); ?>" name="departments[<?php echo e($i); ?>][dept_id]" value="<?php echo e($w['ID']); ?>"></td>
                                    <td width="10%"><input type="checkbox" id="mail-<?php echo e($i); ?>" name="departments[<?php echo e($i); ?>][send_mail]" value="1"></td>
                                    <td><?php echo e($w['name']); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <?php echo e(csrf()); ?>


    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Create</button>
            <a href="/users" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/attendance-portal/views/cpanel/users/create.blade.php ENDPATH**/ ?>