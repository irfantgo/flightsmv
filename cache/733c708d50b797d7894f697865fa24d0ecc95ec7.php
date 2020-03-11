<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-success">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="<?php echo e(assets('img/TTH_Vector_White_full.svg')); ?>" alt="TTH Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo e(env('APP_NAME')); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo e(assets('adminlte/img/AdminLTELogo.png')); ?> " class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo e(\Heliumframework\Session::get('user')['display_name']); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <?php
                    $_navigationLinks = json_decode(file_get_contents(dirname(__DIR__) . '/resources/navigation.json'));
                ?>

                <?php $__currentLoopData = $_navigationLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if( $link->permission == '' ): ?>
                        <?php echo $__env->make('cpanel.parts.navlink', ['link' => $link], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php else: ?>
                        <?php if( \Heliumframework\Auth::hasPermission( $link->permission ) ): ?>
                            <?php echo $__env->make('cpanel.parts.navlink', ['link' => $link], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <li class="nav-header">Departments</li>

                <?php
                    $_navigationLinks = json_decode(file_get_contents(dirname(__DIR__) . '/resources/navigation.json'));
                ?>

                <?php $__currentLoopData = \Heliumframework\Session::get('user')['departments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(\Heliumframework\Auth::hasPermission(['VIEW_PAYROLL', 'VIEW_ATTENDANCE'])): ?> 
                    <li class="nav-item has-treeview">
                        <a href="/department/payroll/<?php echo e($dept['ID']); ?>" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <p><?php echo e($dept['name']); ?></p>
                        </a>
                    </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside><?php /**PATH /Users/shan/www/tth/attendance-portal/views/cpanel/parts/aside.blade.php ENDPATH**/ ?>