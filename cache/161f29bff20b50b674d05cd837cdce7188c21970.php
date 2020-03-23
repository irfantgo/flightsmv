<nav class="main-header navbar navbar-expand navbar-dark navbar-danger">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
        
        
            
        
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <?php if(\Heliumframework\Auth::hasPermission('UP_SETTINGS')): ?>
            <li class="nav-item"><a class="nav-link" href="/settings"><i class="fas fa-cog"></i></a></li>
        <?php endif; ?>
        
        <li class="nav-item"><a class="nav-link" href="/logout"><i class="fas fa-power-off"></i></a></li>
    </ul>
</nav>
<!-- /.navbar --><?php /**PATH /Users/shan/www/flightsmv/views/cpanel/parts/topnav.blade.php ENDPATH**/ ?>