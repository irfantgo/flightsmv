<?php

    define('BOT_TOKEN', '185576081:AAHdZ1AoiS8-RHi0HryspWZNk1KoFUUQ9Ko');


    // Get database configuration
    if( file_exists(__DIR__ . '/dbconfig.php') == false ) {
        die("You forgot to create a database configuration file");
    }

    include __DIR__ . '/dbconfig.php';

    // Check for composer modules
    if( is_dir(__DIR__ . '/vendor') == false ) {
        die("Did you install composer modules?");
    }


    // define('DBHOST', '127.0.0.1');
    // define('DBUSER', 'root');
    // define('DBPASS', 'qwerthaanu16');
    // define('DBNAME', 'mordis');


    // Set Timezone
    date_default_timezone_set('Asia/Karachi');
