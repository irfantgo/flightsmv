<?php   

    // Create a _arduino directory if does not exists
    if( is_dir(dirname(__DIR__) . '/arduino') == false ) {
        mkdir(dirname(__DIR__) . '/arduino');
    }

    // Create a json file for status
    if( file_exists(dirname(__DIR__) . '/arduino/pinlist.json') == false ) {
        touch(dirname(__DIR__) . '/arduino/pinlist.json');
    }

    // Device Mapping
    $devices['11'] = 'D0';
    $devices['12'] = 'D6';
    $devices['13'] = 'D7';

    // Get the pin list
    $pinlist = json_decode(file_get_contents(dirname(__DIR__) . '/arduino/pinlist.json'));

    $arduino_command = $telegram->text;

    $switch = (int)substr($arduino_command, -1, 1);
    $deviceid = substr($arduino_command, 0, strlen($arduino_command) - 1);

    // Check if device exists
    if( array_key_exists($deviceid, $devices) == false ) {
        
        $response_text = 'Device '.$deviceid.' not found';

    }
    // Else 
    else {

        $pin = $devices[$deviceid];
    
        // Look up for pin
        if( empty($pinlist) ) {
            $pinlist[] = ['pin' => $pin, 'status' => $switch];
        }
        // Else, find the pin and update
        else {
    
            $count = 0;
            $pinFound = false;
    
            foreach( $pinlist as $tab ) {
                // If found
                if( $tab->pin == $pin ) {
                    $pinlist[$count]->status = $switch;
                    $pinFound = true;
                }
                $count++;
            }
    
            // Create a new pin if pin not found
            if( $pinFound == false ) {
                $pinlist[] = ['pin' => $pin, 'status' => $switch];
            }
    
        }
    
        // Write New Information
        file_put_contents(dirname(__DIR__) . '/arduino/pinlist.json', json_encode($pinlist));
    
        // Response Text
        $response_text = 'Device ' . $deviceid . ' is now switched ' . ( $switch == 1 ? 'ON' : 'OFF' );

    }


