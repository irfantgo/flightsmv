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
        

        // Handle Call Back Queries
        if ( isset($updates['callback_query']) ) {
            $chatId = $updates['callback_query']['from']['id'];
            $data = $updates['callback_query']['data'];
            $telegram->sendMessage($chatId, $updates['callback_query']['data']);
            $split = explode('_', $data);
            $action = $split[0];
            $id = $split[1];

            if ( $action == 'remindme' ) {
                $telegram->sendMessage($chatId, 'Reminder Called for ' . $id);
            }
            else {
                $telegram->sendMessage($chatId, 'Invalid action');
            }

        }

        // Handle Normal Text Message
        if ( isset($updates['message']) ) {
            $chatId = $updates['message']['chat']['id'];
            $text = $updates['message']['text'];

            if ( $text == '/start' ) {
                $telegram->sendMessage($chatId, 'Welcome to Flight MV. You can type a flight number to get updates.');
            }
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