<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('page_title','Welcome'); ?> | <?php echo e(env('APP_NAME')); ?></title>
    
    <?php echo $__env->make('heliumframework-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <link rel="icon" type="image/png" href="<?php echo e(assets('touch-icons/apple-touch.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(assets('touch-icons/apple-touch.png')); ?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
    <link rel="stylesheet" href="<?php echo e(assets( 'adminlte/plugins/fontawesome-free/css/all.min.css' )); ?>">
    <link rel="stylesheet" href="<?php echo e(assets( 'adminlte/css/adminlte.css' )); ?>">
</head><?php /**PATH /Users/shan/www/tth/tth-cashdrawers/views/cpanel/html-head.blade.php ENDPATH**/ ?>