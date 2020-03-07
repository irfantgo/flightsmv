<?php   

    $dbConn = new MysqliDb ($dbConfig['DBHOST'], $dbConfig['DBUSER'], $dbConfig['DBPASS'], $dbConfig['DBNAME']);

    $response_text = $telegram->text;
    