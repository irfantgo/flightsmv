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

    // Terminate if no requests found
    if ( empty($dataset) ) { exit; }

    $telegram = new Telegram(_env('TELEGRAM_BOT_TOKEN'), _env('TELEGRAM_BOT_NAME'));

    foreach ( $dataset as $data ) {

        $flightId = $data['flight_id'];
        $flight = $dbConn->rawQuery("SELECT * from flightinfo WHERE ID = $flightId")[0];

        // Check if status changed
        if ( $data['current_status'] != $flight['flight_status'] ) {

            // Send notification
            $msg = $flight['airline_name'] . " Flight no " . $flight['flight_no'] . " is " . $flight['flight_status'];
            $telegram->sendMessage($data['telegram_chat_id'], $msg);

            $d['current_status'] = $flight['flight_status'];

            if ( $flight['flight_status'] == 'CLOSED' )     { $d['stop_reminder'] = 1;   }
            if ( $flight['flight_status'] == 'CANCELLED' )  { $d['stop_reminder'] = 1;   }
            if ( $flight['flight_status'] == 'LANDED' )     { $d['stop_reminder'] = 1;   }

            // Update record
            if ( $dbConn->update('tbl_reminders', $d) == false ) {
                log_message("An error occured when trying to update record");
            }

        }

    }

