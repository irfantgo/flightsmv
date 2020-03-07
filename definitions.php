<?php 

    define('DEPARTURE_LINK', 'http://www.fis.com.mv/xml/depart.xml');
    define('ARRIVALS_LINK', 'http://www.fis.com.mv/xml/arrive.xml');
    define('FLIGHT_LOGO_PREFIX', 'http://fis.com.mv/webfids/images/');

    // Statuses
    $statues = [
        'LA' => 'LANDED',
        'CA' => 'CANCELLED',
        'DE' => 'DELAYED',
        'FZ' => 'CLOSED',
        'BO' => 'BOARDING',
        'FC' => 'FINAL CALL',
        'DP' => 'DEPARTED'
    ];    

    // Bounds
    $bounds = [
        'D' => 'Domestic',
        'I' => 'International'
    ];