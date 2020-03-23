<?php   

    $dbConn = new MysqliDb ($dbConfig['DBHOST'], $dbConfig['DBUSER'], $dbConfig['DBPASS'], $dbConfig['DBNAME']);

    $airline_id = $telegram->text;

    if( empty($airline_id) ) {
        $response_text = 'You forgot to mention the airline';
    }
    else {

        // Clean up flight no
        $airline_id = strtoupper($airline_id);

        // Look for the flight
        $dbConn->where('airline_id', $airline_id);
        $flights = $dbConn->get('flightinfo');

        if( empty($flights) ) {
            $response_text = 'Sorry, I was unable to find flight information for ' . $airline_id;
        }
        else {

            $response_text = '';

            foreach( $flights as $flight ) {

                $response_text .= strtoupper($flight['direction']) . "\n";
                $response_text .= "Airline: " . $flight['airline_name'] . "\n";
                $response_text .= "Flight No: " . $flight['flight_no'] . "\n";
                $response_text .= "Date: " . $flight['scheduled_d'] . "\n";
                $response_text .= "Time: " . $flight['scheduled_t'] . "\n"; 
                $response_text .= "Status: " . ($flight['flight_status'] ? $flight['flight_status'] : 'Not Available') . "\n"; 
                $response_text .= "----------------------------\n"; 

            }

        }

    }

    