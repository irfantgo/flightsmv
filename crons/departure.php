<?php
    /**
     * FETCH DEPARTURE FLIGHT INFORMATION FROM FIS
     */

    echo "Departure Job Running\n";

    // Bootstrap
    include __DIR__ . '/bootstrap.php';
    
    // Initialize Database
    $dbConn = new MysqliDb ( _env('DB_HOST'), _env('DB_USER'), _env('DB_PASS'), _env('DB_NAME') );


    // Linked
    $depart_string = file_get_contents(DEPARTURE_LINK);
    $depart_xml = simplexml_load_string($depart_string);

    $departure_flights = [];
    $count = 0;

    // Notify that dataset was empty
    if(empty($depart_xml)) { echo "Dataset is empty\n"; }

    if(!empty($depart_xml)) : foreach( $depart_xml->Flight as $flight ) :

        // Cleaning Data
        $airline_id     = (string) $flight->AirLineID;
        $airline_name   = (string) $flight->AirLineName;
        $flight_no      = (string) $flight->FlightID;
        $scheduled_d    = (string) $flight->Date;
        $scheduled_t    = (string) $flight->Scheduled;
        $estimated_t    = (string) $flight->Estimated;
        $status         = (string) $flight->Status;
        $status         = ( isset($status) && !empty($status) ? $status : NULL ); // Override after cleaning
        $status         = trim($status); // Override after cleaning
        $direction      = 'arrival';
        $bound          = (string) $flight->CarrierType;


        // Lookup for flight
        $dbConn->where('flight_no', $flight_no);
        $dbConn->where('scheduled_d', $scheduled_d);
        $dbConn->where('scheduled_t', $scheduled_t);
        $dbConn->where('direction', $direction);
        $found = $dbConn->getOne('flightinfo');

        // If flight found
        if( !empty($found) ) {

            // Check if status changed... Then update
            if( !empty($status) && $found['status_int'] != $status ) {

                // Update
                $data = [
                    'estimated_t'   => (!empty($status) && $status == "DE" ? NULL : date('H:i', strtotime($estimated_t))),
                    'status_int'    => (empty($status) ? NULL : $status),
                    'flight_status' => (empty($status) ? NULL : $statues[$status])
                ];
                
                $dbConn->where('ID', $found['ID']);
                $dbConn->update('flightinfo', $data);

            }

        }
        // Else, add new flight
        else {

            $data = [
                'airline_id'    => $airline_id,
                'airline_name'  => $airline_name,
                'flight_no'     => $flight_no,
                'scheduled_d'   => date('Y-m-d', strtotime($scheduled_d)),
                'scheduled_t'   => date('H:i', strtotime($scheduled_t)),
                'estimated_t'   => ($status == "DE" ? NULL : date('H:i', strtotime($estimated_t))),
                'status_int'    => (empty($status) ? NULL : $status),
                'flight_status' => (empty($status) ? NULL : $statues[$status]),
                'airline_img'   => FLIGHT_LOGO_PREFIX.strtolower($airline_id).'.gif',
                'direction'     => $direction,
                'bound'         => $bound
            ];
    
            if( ! $dbConn->insert('flightinfo', $data)){

                // Write errors
                log_message("ERROR: " . $dbConn->getLastError(), __DIR__ . '/trash/log.txt');
                
            }
            
        }

    endforeach; endif;

    echo "Done\n";

