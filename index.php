<?php

    echo "WOO";
    exit;

    // Include Configuration
    include __DIR__ . '/config.php';

    // Automatically generate an access token
    $auth_access_token = date('Ymd');

    // Authenticate
    if( isset($_GET['token']) && $_GET['token'] == $auth_access_token ) {

        include __DIR__ . '/telegram.php';

        $telegram = new Telegram(BOT_TOKEN);

        // Response to GET request
        if( isset($_GET['text']) ) {
            $telegram->send_text($_GET['text'], SHAN_CHAT_ID);
        }
    
        // Response to POST request
        if( isset($_POST['message']) ) {
            $telegram->send_text($_POST['message'], SHAN_CHAT_ID, $_POST['parse_mode']);
        }

    }
