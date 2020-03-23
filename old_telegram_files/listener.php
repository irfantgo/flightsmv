<?php

    // Include Configuration
    include __DIR__ . '/init.php';

    // Include functions
    include __DIR__ . '/functions.php';

    // Include Telegram Library
    include __DIR__ . '/telegram.php';

    // Automatically generate an access token
    $auth_access_token = date('Ymd');

    $telegram = new Telegram(BOT_TOKEN);

    $update_id = null;

    // Keep on listening
    while(true) :

        $updates = $telegram->get_updates($update_id, null, 100);

        if( !empty($updates) ) {

            foreach( $updates->result as $result ) {

                $update_id = $result->update_id;

                // Log the updates
                $upp = __DIR__ . '/.updates';
                if( file_exists($upp) ) { unlink($upp); } touch($upp);
                file_put_contents($upp, print_r($updates, true));

                // Process a command


                // Process Callback Query
                if( isset($result->callback_query) ) {
                    
                    $callback_query = $result->callback_query;
                    $reply_to_message = $callback_query->id;
                    $data = $callback_query->data;

                    // Set Chat ID
                    $telegram->set_chat_id( $callback_query->from->id );

                    $xx = explode('/', $data);

                    if( $xx[0] == 'mark-as-paid' ) {

                        // Load Bills
                        $bill_file = __DIR__ . '/crons/bill-reminders/bills.json';
                        $bills = json_decode(file_get_contents($bill_file));

                        $service_number = $xx[1];

                        $reset = [];
                        $count = 0;
                        foreach( $bills as $bill ) {
                            
                            
                            $reset[$count]["account"]           = $bill->account;
                            $reset[$count]["service_number"]    = $bill->service_number;
                            $reset[$count]["due_date"]          = $bill->due_date;
                            $reset[$count]["paid"]              = ( $service_number == $bill->service_number ? 'yes' : $bill->paid );
                    
                            $count++;
                    
                        }
                    
                        // Remove the current bill file
                        unlink($bill_file);
                    
                        // Recreate bill file
                        touch($bill_file);
                        file_put_contents($bill_file, json_encode($reset));

                        // Send Reply
                        $telegram->answer_callback_query($reply_to_message, 'Marked as paid', true);
                        $telegram->hide_keyboard(null, $callback_query->message->message_id);

                    }


                }

            }

        }

    endwhile;

