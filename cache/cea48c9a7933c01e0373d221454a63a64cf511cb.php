<?php $__env->startSection('page_title', 'Cashiers'); ?>
<?php $__env->startSection('page_content'); ?>


<form action="/cashiers/create" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/cashiers">
    <h5>Create New Cashier</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Cashier Information
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
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Choose Accessible Cash Drawers
                </div>
                <div class="card-body" style="min-height: 400px; overflow: scroll;">

                    <?php if( empty($workstations) ): ?>
                        <p>No Active Workstations Found</p>
                    <?php else: ?>    
                        <?php $__currentLoopData = $workstations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ws): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="3">
                                        <?php echo e($ws['group_name']); ?>

                                        <div class="float-right">
                                            <a href="#" class="btn btn-outline-dark btn-sm checkbox-toggler" data-action="select" data-id="<?php echo e($ws['ID']); ?>">Select All</a>
                                            <a href="javascript:void" class="btn btn-outline-dark btn-sm checkbox-toggler" data-action="deselect" data-id="<?php echo e($ws['ID']); ?>">Deselect All</a>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Workstation</th>
                                    <th>Description</th>
                                </tr>
                                <?php $__currentLoopData = $ws['workstations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wrkstns): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><input type="checkbox" name="workstations[]" value="<?php echo e($wrkstns['ID']); ?>" class="child-id-<?php echo e($ws['ID']); ?>" value="<?php echo e($wrkstns['ID']); ?>"></td>
                                        <td><?php echo e($wrkstns['hostname']); ?></td>
                                        <td><?php echo e($wrkstns['description']); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                            <br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <?php echo $__env->make('cpanel.alerts.callouts', ['callout_type' => 'info', 'callout_title' => 'Please note the following', 'callout_message' => '<p>Cashier <strong>Email</strong> will be created according to the username provided. So please enter the username correctly.</p>
                    <p><strong>Pin Code</strong> will be auto generated and sent via email to the cashier</p>'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo e(csrf()); ?>


    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Create</button>
            <a href="/cashiers" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/cashiers/create.blade.php ENDPATH**/ ?>