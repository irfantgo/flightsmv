<?php $__env->startSection('page_title', 'Users'); ?>
<?php $__env->startSection('page_content'); ?>


<form action="/users/update/<?php echo e($user['ID']); ?>" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/users/edit/<?php echo e($user['ID']); ?>">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Edit User
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter staff full name" autocomplete="off" value="<?php echo e($user['display_name']); ?>" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Active Directory Username" autocomplete="off" value="<?php echo e($user['username']); ?>" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="isActive">
                            <input <?php echo e(( $user['isActive'] ? ' checked ' : '' )); ?> type="checkbox" id="isActive" name="isActive" value="1">
                            Account is Active</label>
                        
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    User Roles
                </div>
                <div class="card-body" style="min-height: 400px; overflow: scroll;">

                    <?php if( empty($roles) ): ?>
                        <p>No Roles Found</p>
                    <?php else: ?>    
                        <table class="table table-bordered">
                            <tbody>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><input <?php echo e(( in_array($w['code'], explode('|', $user['roles'])) ? ' checked ' : '' )); ?> type="checkbox" id="w-<?php echo e($i); ?>" name="roles[]" value="<?php echo e($w['code']); ?>"></td>
                                    <td><?php echo e($w['description']); ?></td>
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

    <?php echo $__env->make('cpanel.alerts.callouts', ['callout_type' => 'info', 'callout_title' => 'Please note the following', 'callout_message' => '<p>User <strong>Email</strong> will be created according to the username provided. So please enter the username correctly.</p>'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo e(csrf()); ?>


    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Edit</button>
            <a href="/users" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/users/edit.blade.php ENDPATH**/ ?>