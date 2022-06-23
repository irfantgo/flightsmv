<?php
    /**
     * SEND REMINDERS
     */

    echo "Reminder Job Running\n";

    // Bootstrap
    include __DIR__ . '/bootstrap.php';
    
    // Initialize Database
    $dbConn = new MysqliDb ( _env('DB_HOST'), _env('DB_USER'), _env('DB_PASS'), _env('DB_NAME') );

    $dataset = $dbConn->rawQuery("SELECT * FROM tbl_reminders WHERE stop_reminder = 0");

    if ( empty($dataset) ) { exit; }

    foreach ( $dataset as $data ) {

        $flightId = $data['flight_id'];
        $flight = $dbConn->rawQuery("SELECT * from flightinfo WHERE ID = $flightId");

        // Check if status changed
        if ( $data['current_status'] != $flight['flight_status'] ) {

            // Send notification
            $msg = $flight['airline_name'] . " Flight no " . $flight['flight_no'] . " is " . $flight['flight_status'];
            shell_exec('curl -X POST -d "{\"text\": \"'.$msg.'\"}" -H "Content-Type: application/json" https://api.pushcut.io/q5sFH41aBmrdVtXWHPCaa/notifications/MyNotification');

            $d['current_status'] = $flight['flight_status'];

            if ( $flight['flight_status'] == 'CANCELLED' || $flight['flight_status'] == 'LANDED' ) {
                $d['stop_reminder'] = 1;
            }

            // Update record
            if ( $dbConn->update('tbl_reminders', $dataset) == false ) {
                log_message("An error occured when trying to update record");
            }

        }

    }

