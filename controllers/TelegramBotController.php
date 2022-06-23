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
        $text = $updates['message']['text'];

        if ( $text == '/start' ) {
            $telegram->sendMessage($chatId, 'Welcome to Flight MV. You can type a flight number to get updates.');
        }
        else {

            $flightNo = $text;
            
            // Find flight information
            $flight = new Flights();
            $info = $flight->conn->rawQuery("SELECT * FROM flightinfo where flight_no = '$flightNo'");

            if ( empty($info) ) {
                $telegram->sendMessage($chatId, 'Unable to find flight information for ' . $flightNo);
            }
            else {
                // $msg = '<b>Flight '.$flightNo.'</b>';
                $msg = json_encode($info);
                // foreach ( $info as $row ) {
                //     $msg .= json_encode($row);
                // }
                $telegram->sendMessage($chatId, $msg);
            }

        }

    }

}