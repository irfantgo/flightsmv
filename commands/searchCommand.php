<?php   

    $dbConn = new MysqliDb ($dbConfig['DBHOST'], $dbConfig['DBUSER'], $dbConfig['DBPASS'], $dbConfig['DBNAME']);

    $name = explode(' ', $telegram->text);

    if( isset($name[0]) ) {
        $dbConn->where('first_name', $name[0]);
    }

    if( isset($name[1]) ) {
        $dbConn->where('middle_name', $name[1]);
    }

    if( isset($name[2]) ) {
        $dbConn->where('last_name', $name[2]);
    }

    $records = $dbConn->get('sorted');

    if( !empty($records) ) {

        $response_text = '';

        foreach( $records as $record ) {

            $response_text .= ui_element_person_tag($record);
            $response_text .= "\n\n";

        }

        $response_text .= 'Total '.count($records).' Record(s) ';

    }
    else {
        $response_text = 'Information not found for ' . $telegram->text;
    }