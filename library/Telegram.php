<?php 
class Telegram {

    protected $token;
    protected $url;
    protected $actualBotname;

    public function __construct( $token, $botname )
    {
        $this->token = $token;
        $this->url = "https://api.telegram.org/bot$token";
        $this->actualBotname = $botname;
    }

    public function getUpdates($updateId = null)
    {
        $dataset['timeout'] = 100;
        if( ! empty($updateId) ) { $dataset['offset'] = $updateId + 1; }
        return $this->_call($this->url.'/getUpdates', $dataset);
    }

    public function sendMessage( $chatId, $message )
    {
        $payload = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'html'
        ];
        return $this->_call($this->url.'/sendMessage', $payload);
    }

    public function sendInlineKeyboard( $chatId, $message, $inputKeyboard = [] )
    {
        $payload = [
            'chat_id' => $chatId,
            'text' => $message,
            'reply_markup' => json_encode(['inline_keyboard' => $inputKeyboard]),
            'parse_mode' => 'html'
        ];
        return $this->_call($this->url.'/sendMessage', $payload);
    }

    public function sendInlineKeyboardTest( $chatId, $message, $replyId, $inputKeyboard = [] )
    {
        $payload = [
            'chat_id' => $chatId,
            'text' => $message,
            'reply_to_message_id' => $replyId,
            'reply_markup' => json_encode(['inline_keyboard' => $inputKeyboard]),
            'parse_mode' => 'html'
        ];
        return $this->_call($this->url.'/sendMessage', $payload);
    }

    

    public function callbackQuery( $updateId, $chatId, $message )
    {
        $payload = [
            'id' => $updateId,
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'html'
        ];
        print_r($payload);
        return $this->_call($this->url.'/CallbackQuery', $payload);
    }

    public function answerCallbackQuery( $callbackQueryId, $message )
    {
        $payload = [
            'callback_query_id' => $callbackQueryId,
            'text' => $message,
            'parse_mode' => 'html'
        ];
        print_r($payload);
        return $this->_call($this->url.'/answerCallbackQuery', $payload);
    }

    public function editMessageText( $messageId, $chatId, $replyMarkup )
    {
        $payload = [
            'message_id' => $messageId,
            'chat_id' => $chatId,
            'parse_mode' => 'html'
        ];
        if( ! empty($replyMarkup) ) { $payload['reply_markup'] = json_encode(['inline_keyboard' => $replyMarkup]); }
        return $this->_call($this->url.'/editMessageText', $payload);
    }

    /**
     * 
     *
     * @param   string  $chatId  Chat ID
     * @param   string  $action     typing | upload_photo | record_video or upload_video | 
     *                              record_voice or upload_voice | upload_document | choose_sticker | 
     *                              find_location | record_video_note or upload_video_note
     *
     * @return  object  JSON Response
     */
    public function sendChatAction( $chatId, $action )
    {
        try {
            $allowedActions = ['typing','upload_photo','record_video','upload_video','record_voice','upload_voice','upload_document','choose_sticker','find_location','record_video_note', 'upload_video_note'];

            if( ! in_array($action, $allowedActions) ) {
                throw New Exception('Invalid action. Please use one of the following: ' . implode(', ', $allowedActions));
            }

            $payload = [
                'chat_id' => $chatId,
                'action' => $action
            ];
            return $this->_call($this->url.'/sendChatAction', $payload);
        }
        catch( Exception $e ) {
            die($e->getMessage());
        }
    }

    public function forceReplyMessage( $chatId, $message, $placeholder, $selective = false )
    {
        $payload = [
            'chat_id' => $chatId,
            'text' => $message,
            'reply_markup' => json_encode([
                'force_reply' => true,
                'input_field_placeholder' => $placeholder,
                'selective' => $selective
            ]),
            'parse_mode' => 'html'
        ];
        return $this->_call($this->url.'/sendMessage', $payload);
    }

    /**
     * Send a venue
     *
     * @param   string  $chatId         Chat ID
     * @param   float  $lat             Latitude
     * @param   float  $long            Longitute
     * @param   string  $title          Name of the address (title)
     * @param   string  $address        Street Address
     * @param   array  $moreOptions     More attributes (https://core.telegram.org/bots/api#sendvenue)
     *
     * @return  object              JSON Response
     */
    public function sendVenue( $chatId, $lat, $long, $title, $address, $moreOptions = [] )
    {
        if( ! empty($moreOptions) ) { $payload = $moreOptions; }
        $payload['chat_id'] = $chatId;
        $payload['latitude'] = $lat;
        $payload['longitude'] = $long;
        $payload['title'] = $title;
        $payload['address'] = $address;
        return $this->_call($this->url.'/sendVenue', $payload);
    }

    /**
     * Send a poll to a group
     *
     * @param   string      $chatId                Chat ID
     * @param   string      $question              Poll question
     * @param   array       $options               Answer Options
     * @param   string      $type                  Quiz mode or Regular Mode, default to Regular
     * @param   array       $moreOptions           More options (https://core.telegram.org/bots/api#sendpoll)
     *
     * @return  void
     */
    public function sendPoll( $chatId, $question, $options = [], $type = 'regular', $moreOptions = [])
    {
        if( !empty($moreOptions) ){ $payload = $moreOptions; }
        $payload['chat_id']     = $chatId;
        $payload['question']    = $question;
        $payload['type']        = $type;
        $payload['options']     = json_encode($options);
        $payload['parse_mode']  = 'html';

        return $this->_call($this->url.'/sendPoll', $payload);
    }

    /**
     * Send a contact
     *
     * @param   string  $chatId         Telegram Chat Id
     * @param   string  $phoneNumber    Phone number
     * @param   string  $firstName      First name
     * @param   string  $lastName       Last name
     * @param   string  $firstName      First name
     *
     * @return  object                  JSON response
     */
    public function sendContact( $chatId, $phoneNumber, $firstName, $lastName = null )
    {
        $payload['chat_id']         = $chatId;
        $payload['phone_number']    = $phoneNumber;
        $payload['first_name']      = $firstName;
        if( ! empty($lastName) ) {
            $payload['last_name']       = $lastName;
        }
        return $this->_call($this->url.'/sendContact', $payload);
    }

    public function sendDice( $chatId, $emoji = null )
    {
        $payload['chat_id']     = $chatId;
        $payload['emoji']    = $emoji;
        return $this->_call($this->url.'/sendDice', $payload);
    }

    public function sendAudio( $chatId, $audio )
    {
        $payload['chat_id']     = $chatId;
        $payload['audio']       = $audio;
        return $this->_call($this->url.'/sendAudio', $payload);
    }

    public function setMyCommands( $commands )
    {
        $payload = ['commands' => json_encode($commands)];
        return $this->_call($this->url.'/setMyCommands', $payload);
    }

    public function getMyCommands()
    {
        return $this->_call($this->url.'/getMyCommands');
    }

    public function deleteMyCommands( $commands )
    {
        $payload = ['commands' => json_encode($commands)];
        echo $this->_call($this->url.'/setMyCommands', $payload);
    }

    public function isCommand( $command )
    {
        return ( $command[0] == "/" ? true : false );
    }

    public function validateBot( $command )
    {
        // Check if a command
        if( $this->isCommand($command) ) {
            if( strpos($command, '@') !== false ) {
                $inputBotname = substr($command, strpos($command, '@'), strlen($command));
                return ( $inputBotname == $this->actualBotname ? true : false );
            }
            return true;
        }
    }

    public function getCommand( $command )
    {
        $command = str_replace('/', '', $command);
        // Remove bot name
        if( strpos($command, '@') !== false ) {
            $inputBotname = substr($command, strpos($command, '@'), strlen($command));
            $command = str_replace($inputBotname, '', $command);
        }
        return $command;
    }

    public function getFile( $fileId )
    {
        $payload = ['file_id' => $fileId];
        return $this->_call($this->url.'/getFile', $payload);
    }

    // todo: might have to look into
    public function downloadPhoto( $filePath )
    {
        return file_get_contents($this->url.'/'.$filePath);
    }

    private function _call( $url, $postItems = null )
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

        log_message(print_r($url, true));
        
        if( empty($postItems) == false ) {
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postItems));
        }

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        log_message(print_r($server_output, true));

        curl_close($ch);

        return $server_output;
    }

}