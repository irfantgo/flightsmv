<?php 

    // Include Configuration
    include __DIR__ . '/config.php';

    // Include Composer Modules
    include __DIR__ . '/vendor/autoload.php';

    // Include Telegram
    include __DIR__ . '/telegram.php';

    // Include UI Elements
    include __DIR__ . '/ui.php';

    // Create New Instance
    $telegram = new Telegram(BOT_TOKEN);
    $telegram->get_updates_from_webhook();

    $telegram->set_chat_id();

    if( $telegram->is_command() ) {

        // Include Command File
        $commandFile = __DIR__ . '/commands' . $telegram->command . 'Command.php';

        if( file_exists($commandFile) ) {

            // Authenticate
            if( $telegram->get_chat_id() == SHAN_CHAT_ID ) {

                include $commandFile;

            }
            // Else, notify user that, command cannot be executed
            else {

                $response_text = "Sorry, I cannot provide that information for you.";

            }
            

        }
        else {
            $response_text = "I did not understand what you meant";
        }

        $telegram->send_text($response_text, null, 'HTML');

    }
    else {

        // $telegram->send_text('Not a command');

    }