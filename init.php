<?php

    // Get database configuration
    if( file_exists(__DIR__ . '/config.php') == false ) {
        die("You forgot to create a database configuration file\n");
    }
    
    // Include database configuration
    include __DIR__ . '/config.php';

    // Check for composer modules
    if( is_dir(__DIR__ . '/vendor') == false ) {
        die("Did you install composer modules?\n");
    }

     // Check if bot token is set
     if( defined('BOT_TOKEN') || BOT_TOKEN == "" ) {
        die("Telegram bot token not set\n");
    }

    // Set Timezone
    date_default_timezone_set('Asia/Karachi');
