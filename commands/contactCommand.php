<?php   

    $dbConn = new MysqliDb (DBHOST, DBUSER, DBPASS, DBNAME);

    $dbConn->where('contact_no', $telegram->text);

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