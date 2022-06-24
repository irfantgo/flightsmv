<?php
/**
 * Telegram Bot Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Notifications;
use Heliumframework\Session;
use Heliumframework\Hash;
use Heliumframework\Controller;
use Heliumframework\Validate;

class TelegramBotController extends Controller
{
    
    public function index()
    {
        $updates = json_decode(file_get_contents("php://input"), true);
        $telegram = new Telegram(_env('TELEGRAM_BOT_TOKEN'), _env('TELEGRAM_BOT_NAME'));
        $chatId = $updates['message']['chat']['id'];
        $text = (isset($updates['message']) ? $updates['message']['text'] : '');

        if ( $text == '/start' ) {
            $telegram->sendMessage($chatId, 'Welcome to Flight MV. You can type a flight number to get updates.');
        }
        else {

            // Answer Call backs
            if (isset($update['callback_query'])) {

                $data = $update['callback_query']['data'];
                $x = explode('_', $data);
                $action = $x[0];
                $id = $x[1];

                if ( $action == 'remindme' ) {
                    $telegram->sendMessage($chatId, 'Setting Reminder');
                }
                
            }
            // Anything else, try to find a flight information
            else {

                $flightNo = $text;
            
                // Find flight information
                $flight = (new Flights())->select_flight_by_no( $flightNo );

                if ( empty($flight) ) {
                    $telegram->sendMessage($chatId, 'Unable to find flight information for ' . $flightNo);
                }
                else {

                    // Clean up flight information
                    $msg   = 'Flight No: ' . $flight['flight_no'] . "\n";
                    $msg  .= 'Airlines: ' . $flight['airline_name'] . "\n";
                    $msg  .= 'Date: ' . date("d F Y", strtotime($flight['scheduled_d'])) . "\n";
                    $msg  .= 'Time: ' . date("H:i", strtotime($flight['scheduled_t'])) . "\n";
                    $msg  .= 'Status: ' . (empty($flight['flight_status']) ? 'NA' : $flight['flight_status']) . "\n";
    
                    $keyboard = [
                        [
                            ['text' => 'Keep Me Posted', 'callback_data' => 'remindme_' . $flight['ID']]
                        ]
                    ];
                    
                    $telegram->sendInlineKeyboard($chatId, $msg, $keyboard);

                }

            }

        }

    }

}