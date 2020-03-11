<?php 

    // Include Configuration
    include __DIR__ . '/config.php';

    // Include Composer Modules
    include __DIR__ . '/vendor/autoload.php';

    // Include Telegram
    include __DIR__ . '/telegram.php';

    // Include UI Elements
    include __DIR__ . '/ui.php';

    // Create New Instance
    $telegram = new Telegram( BOT_TOKEN );
    echo $telegram->set_webhook( BOT_WEBHOOK );

    