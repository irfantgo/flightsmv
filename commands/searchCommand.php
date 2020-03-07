<?php   

    $dbConn = new MysqliDb ($dbConfig['DBHOST'], $dbConfig['DBUSER'], $dbConfig['DBPASS'], $dbConfig['DBNAME']);

    $flight_no = $telegram->text;

    $response_text = $flight_no;
