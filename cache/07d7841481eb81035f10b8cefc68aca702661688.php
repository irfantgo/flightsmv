<nav>
    <div class="nav-wrapper teal darken-3">
        <a href="/" class="b-logo"><?php echo e(env('APP_NAME')); ?></a>
        <ul class="right hide-on-med-and-down">
            <?php echo $__env->make('cpanel.parts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <li><a href="/logout"><i class="material-icons">power_settings_new</i></a></li>
        </ul>
        <ul class="right show-on-small show-on-medium">
            <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </ul>
    </div>
</nav>
<ul id="slide-out" class="sidenav">
    <li>
        <div class="user-view">
            <div class="background">
                <img style="width: 100%" src="<?php echo e(assets('img/' . \Heliumframework\Session::get('user')['bg_image'])); ?>">
            </div>
            <a href="#user"><img class="circle" src="<?php echo e(getGravatar(\Heliumframework\Session::get('user')['email'])); ?>"></a>
            <a href="#name"><span class="white-text name"><?php echo e(\Heliumframework\Session::get('user')['display_name']); ?></span></a>
            <a href="#email"><span class="white-text email"><?php echo e(\Heliumframework\Session::get('user')['email']); ?></span></a>
        </div>
    </li>
    <?php echo $__env->make('cpanel.parts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <li><a href="/logout">Logout</a></li>
</ul>
<?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/parts/main-header.blade.php ENDPATH**/ ?>