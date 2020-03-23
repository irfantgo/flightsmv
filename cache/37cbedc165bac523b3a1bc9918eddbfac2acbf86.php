<!DOCTYPE html>
<html style="height: auto;" lang="en">
<?php echo $__env->make('cpanel.html-head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body class="sidebar-mini control-sidebar-slide-open accent-warning">
    
    <div class="wrapper">

        
        <?php echo $__env->make('cpanel.parts.topnav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        
        <?php echo $__env->make('cpanel.parts.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        
        <div class="content-wrapper">

            
            <?php echo $__env->make('cpanel.parts.page-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            
            <section class="content">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('page_content'); ?>
                </div>
            </section>
            
            <br>
            <br>
            <br>

        </div>

    </div>

    
    <footer class="main-footer">
        Copyright © <?= date('Y') ?> <strong><a class="text-danger" href="http://www.codered.mv" target="_blank">CODERED</a>.</strong>
    </footer> 


    <?php echo $__env->make('cpanel.html-footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html><?php /**PATH /Users/shan/www/flightsmv/views/cpanel/cpanel.blade.php ENDPATH**/ ?>