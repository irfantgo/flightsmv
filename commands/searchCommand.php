<?php   

    $dbConn = new MysqliDb ($dbConfig['DBHOST'], $dbConfig['DBUSER'], $dbConfig['DBPASS'], $dbConfig['DBNAME']);

    $flight_no = $telegram->text;

    if( empty($flight_no) ) {
        $response_text = 'You forgot to mention the flight number';
    }
    else {

        // Clean up flight no
        $flight_no = str_replace(' ', '', $flight_no);
        $flight_no = strtoupper($flight_no);

        // Look for the flight
        $dbConn->where('flight_no', $flight_no);
        $flights = $dbConn->get('flightinfo');

        if( empty($flights) ) {
            $response_text = 'Sorry, I was unable to find the flight information for ' . $flight_no;
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

    