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
        // $updates = json_decode(file_get_contents("php://input"), true);
        $telegram = new Telegram(_env('TELEGRAM_BOT_TOKEN'), _env('TELEGRAM_BOT_NAME'));
        // $message = "You said " . $updates['message']['text'];
        // $chatId = $updates['message']['chat']['id'];
        // $telegram->sendMessage($chatId, $message);
        log_message("Reached here 1");
        $telegram->sendMessage('188076523', "Test Message");
        log_message("Reached here 2");

    }

}