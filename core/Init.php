<?php
    /**
     * CORE HELPER FUNCTIONS
     * ----------------------
     * A set of functions to help the core to function
     */
    include __DIR__ . '/CoreHelpers.php';


    /**
     * COMPOSER MODULES
     * ----------------
     * Load all composer modules
     */
    if( is_dir(dirname(__DIR__) . '/vendor') == false ) {
        // Die and Dump a message
        dd('Please install composer modules <br><br> <code>composer install</code>');
    }
    require(dirname(__DIR__) . '/vendor/autoload.php');


    /**
     * LIBRARY
     * ---------------
     * Load all the libraries
     */
    $libraries = scandir(dirname(__DIR__) . '/library');
    foreach( $libraries as $library ) {
        $ext = pathinfo($library)['extension'];
        if( $ext == 'php' ) {
            include_once(dirname(__DIR__) . '/library/' . $library);
        }
    }
    

    /**
     * FORM HELPER FUNCTIONS
     * ----------------------
     * A set of functions to help the core to function a form
     */
    include __DIR__ . '/FormHelpers.php';


    /**
     * CORE FILES
     * ----------
     * Load all core files
     */
    require(__DIR__ . '/Controller.php');
    require(__DIR__ . '/Model.php');
    require(__DIR__ . '/Auth.php');
    require(__DIR__ . '/Notifications.php');


    /**
     * Error Reporting
     * ---------------
     * Error showing or logging
     */
    error_reporting(0);
    if( _env('DEV_MODE') == 'true' ){ 
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        ini_set('display_errors', 1);
    }


    /**
     * TIMEZONE
     * --------------
     * Set the timezone
     */
    date_default_timezone_set( _env('TIMEZONE') );


    /**
     * MODELS
     * ---------------
     * Load all the models
     */
    $models = scandir(dirname(__DIR__) . '/models');
    foreach( $models as $model ) {
        $ext = pathinfo($model)['extension'];
        if( $ext == 'php' ) {
            include_once(dirname(__DIR__) . '/models/' . $model);
        }
    }

    
    /**
     * SESSION
     * ---------------
     * Initialize Session
     */
    // ini_set('session.cookie_lifetime', 60 * 60 * 24 * 100);
    // ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 100);
    session_start();


    /**
     * ROUTER
     * --------------
     * Router Module
     */
    $__xx__ = explode('/', $_SERVER['REQUEST_URI']);
    array_shift($__xx__);
    if( $__xx__[0] == 'api' ) {
        include __DIR__ . '/ApiRouter.php';
        include dirname(__DIR__) . '/ApiRouting.php';

        /**
         * Load the requested URL
         */
        Heliumframework\ApiRouter::loadURL();
    } else {
        include __DIR__ . '/Router.php';
        include dirname(__DIR__) . '/Routing.php';
        
        /**
         * Load the requested URL
         */
        Heliumframework\Router::loadURL();
    }
    

    // Only used for debugging
    // Heliumframework\Router::test();