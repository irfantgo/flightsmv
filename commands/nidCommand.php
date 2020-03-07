<?php   

    $dbConn = new MysqliDb (DBHOST, DBUSER, DBPASS, DBNAME);

    $dbConn->where('nid', $telegram->text);
    $record = $dbConn->getOne('sorted');

    if( !empty($record) ) {

        $response_text = ui_element_person_tag($record);
        
    }
    else {
        $response_text = 'Information not found for ' . $telegram->text;
    }