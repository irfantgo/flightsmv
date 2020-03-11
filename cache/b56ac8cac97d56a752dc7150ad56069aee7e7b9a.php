<?php $__env->startSection('page_title', 'Applications'); ?>
<?php $__env->startSection('page_content'); ?>


<?php echo $__env->make('cpanel.parts.page-controls', [
    'navigations' => [
                        '/applications/new' => 'New Application',
                        '/applications/help' => 'Help'
                    ]
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <h2>Help</h2>

        <p>Here is a guide for you get started with making API calls.</p>

        <p>
            Please set <code>drawer_token</code> in the request header and use the <code>application token</code> provided by Tree Top Hospital when making an API call.
        </p>
        <p>All calls must be sent via POST</p>
        
        <h4>Routes</h4>

        <p>Prefix that needs to be used for each route will be <code>http://cashdrawers.tth.local/api</code></p>

        <table class="table">
            <thead>
                <tr>
                    <th>Route</th>
                    <th>Required Attributes</th>
                    <th>Description</th>
                    <th>Return</th>
                </tr>
            </thead>
            <tr>
                <td><code>/login</code></td>
                <td>
                    <code>username</code>
                    <br>
                    <code>pincode</code>
                    <br>
                    <code>hostname</code>
                </td>
                <td>
                    Authenticate user for accessing the cash drawers
                </td>
                <td>
                    <code>status</code> <small>(True or False)</small>
                    <br>
                    <code>port</code> <small>(Workstation Port that was configured)</small>
                    <br>
                    <code>message</code> <small>(A notification message)</small>
                </td>
            </tr>
        </table>

    </div>
    <!-- /.card-body -->
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('cpanel.cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/applications/help.blade.php ENDPATH**/ ?>