<?php

    // Database configuration
    include __DIR__ . '/dbconfig.php';

    $dbConn = new MysqliDb (Array (
        'host' => $dbConfig['DBHOST'],
        'username' => $dbConfig['DBUSER'], 
        'password' => $dbConfig['DBPASS'],
        'db'=> $dbConfig['DBNAME'],
        'port' => $dbConfig['DBPORT'],
        'charset' => 'utf8'));