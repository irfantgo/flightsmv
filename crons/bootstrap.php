<?php 

    /**
     * SET TIMEZONE
     * ---------------
     */
    date_default_timezone_set('Asia/Karachi');

    /**
     * CORE HELPERS
     * ---------------
     */
    include(dirname(__DIR__) . '/core/CoreHelpers.php');

    /**
     * MODELS
     * ---------------
     */
    require(dirname(__DIR__) . '/core/Model.php');

    /**
     * COMPOSER MODULES
     * ----------------
     * Load all composer modules
     */
    if( is_dir(dirname(__DIR__) . '/vendor') == false ) {
        // Die and Dump a message
        echo "Please install composer modules\n";
    }
    
    require(dirname(__DIR__) . '/vendor/autoload.php');

    /**
     * Error Reporting
     * ---------------
     * Error showing or logging
     */
    if( _env('DEV_MODE') ){
        ini_set('display_errors', 1);
    }

    /**
     * Helper Function
     * ------------------------------------
     * A helper function for this application
     */
    include( __DIR__ . '/functions.php');
    
    /**
     * Definitions
     * ------------------------------------
     * Definitions file
     */
    include( __DIR__ . '/definitions.php' );


    /**
     * Telegram
     * ------------------------------------
     * Load telegram library
     */
    // include( __DIR__ . '/telegram.php' );

    $libs = scandir(dirname(__DIR__).'/library');
    foreach( $libs as $lib ) {
        if( $lib != '.' && $lib != '..' ) {
            include_once(dirname(__DIR__).'/library/'.$lib);
        }
    }
    