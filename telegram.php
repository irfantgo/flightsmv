<?php

    /**
     * This file holds a class thats important for Telegram Application.
     * This file is used for implementing the D.R.Y concept
     * @author Ahmed Shan (@thaanu16)
     */

    class Telegram 
    {
        public $command, $text;
        private $prefix_url = '';
        protected $chat_id = null, $username = null, $bot_token = null;
        protected $updates_chunk;

        public function __construct( $bot_token )
        {
            $this->bot_token = $bot_token;
            $this->prefix_url = 'https://api.telegram.org/bot' . $this->bot_token . '/';
        }



        /**
         * Set chat id
         * @param string $chat_id
         * @return void
         */
        public function set_chat_id( $chat_id = null )
        {
            if( $chat_id === null ) {
                $this->chat_id = $this->updates_chunk->message->chat->id;
            }
            else {
                $this->chat_id = $chat_id;
            }
        }

        /**
         * Get chat id
         * @return string
         */
        public function get_chat_id()
        {
           return $this->chat_id; 
        }

        /**
         * Get username
         * @return string
         */
        public function get_username()
        {
           return $this->updates_chunk->message->chat->username;
        }

        /**
         * Get updates
         * @param int $offset
         * @param int $limit 
         * @param int $timeout
         * @return json
         */
        public function get_updates( $offset = null, $limit = null, $timeout = null )
        {

            $exe_url = $this->prefix_url . 'getUpdates?';

            if( $offset != null ) {
                $offset = $offset + 1;
                $exe_url .= 'offset=' . $offset;
            }

            if( $limit != null ) {
                $exe_url .= '&limit=' . $limit;
            }

            if( $timeout != null ) {
                $exe_url .= '&timeout=' . $timeout;
            }

            $this->updates_chunk = json_decode( file_get_contents($exe_url) );

            return $this->updates_chunk;

        }

        /**
         * Get updates from webhook
         * @return object
         */
        public function get_updates_from_webhook()
        {
            $this->updates_chunk = json_decode(file_get_contents('php://input'));

            // Extract Command
            // Check for command
            if( $this->is_command() ) {

                $text = explode(' ', $this->updates_chunk->message->text);

                if( isset($text[1]) ) {
                    unset($text[0]);
                    $this->text = implode(' ', $text);
                }

            }
            else {

                $text = $this->updates_chunk->message->text;

            }

            return $this->update_chunk;
        }

        /**
         * Set webhook
         * @return boolean
         */
        public function set_webhook( $url )
        {

            $data['url'] = $url;
            $url = $this->prefix_url . 'setWebhook';
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close ($ch);

            return $server_output;

        }

        /**
         * Get current webhook
         * @return boolean
         */
        public function get_webhook()
        {

            $url = $this->prefix_url . 'getWebhookInfo';
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close ($ch);

            return $server_output;

        }

        /**
         * Delete current webhook
         * @return boolean
         */
        public function delete_webhook()
        {

            $url = $this->prefix_url . 'deleteWebhook';
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close ($ch);

            return $server_output;

        }

        /**
         * Check whether its a command
         * @return boolean
         */
        public function is_command()
        {
            if( $this->updates_chunk->message->entities[0]->type == 'bot_command' ) {
                preg_match("/\/[a-zA-Z]*/", $this->updates_chunk->message->text, $matches);
                $this->command = ( empty($matches) ? '' : $matches[0] );
                return true;
            }
            return false;
        }

        /**
         * Send a normal text message
         * @param string $message
         * @param string $chatid
         * @param string $parse_mode
         * @return void
         */
        public function send_text( $message, $chatid = null, $parse_mode = 'HTML' ) 
        {

            $data['chat_id'] = ( $chatid == null ? $this->chat_id : $chatid );
            $data['text'] = $message;
            $data['parse_mode'] = $parse_mode;

            $url = $this->prefix_url . 'sendMessage';

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close ($ch);

            return $server_output;

        }

        /**
         * Send a normal text message with a reply keyboard
         * @param string $message
         * @param string $chatid
         * @param array $kdb_options
         * @param string $parse_mode
         * @return void
         */
        public function send_text_with_reply_kbd_inline( $message, $chatid = null, $kbd_options = [], $parse_mode = 'HTML' )
        {
            $chat_id = ( $chatid == null ? $this->chat_id : $chatid );

            $kbd['inline_keyboard'] = $kbd_options;

            $exe_url = $this->prefix_url . 'sendMessage?chat_id='.$chat_id.'&parse_mode='.$parse_mode.'&text=' . urlencode($message) . '&reply_markup=' . urlencode(json_encode($kbd));
            
            // Check if url has less than 255 characters
            if( strlen($message) > 4096 ) {
                $exe_url = $this->prefix_url . 'sendMessage?chat_id='.$chat_id.'&parse_mode='.$parse_mode.'&text=' . urlencode('Message is <b>' . strlen($exe_url) . '</b> character long. Make it short.');
            }

            // Sending a message
            file_get_contents($exe_url);
        }

        /**
         * Answer to a call back query
         * @param string $callback_query_id
         * @param string $text
         * @param string $text
         * @param boolean $show_alert
         * @param boolean $hide_inline_keyboard
         * @param string $url
         * @return void
         */
        public function answer_callback_query( $callback_query_id, $text = '', $show_alert = false, $hide_inline_keyboard = false, $url = '' )
        {

            $exe_url = $this->prefix_url . 'answerCallbackQuery?callback_query_id='.urlencode($callback_query_id);
            
            if( $text != '' ) {
                $exe_url .= '&text=' . urlencode($text);
            }
            
            if( $show_alert == true ) {
                $exe_url .= '&show_alert=' . urlencode($text);
            }

            if( $url != '' ) {
                $exe_url .= '&url=' . urlencode($url);
            }

            // Sending a message
            file_get_contents($exe_url);

        }

        /**
         * Hide keyboard
         * @param string $chatid
         * @param string $messageid
         * @return void
         */
        public function hide_keyboard( $chatid = null, $messageid )
        {

            $chat_id = ( $chatid == null ? $this->chat_id : $chatid );
            $exe_url = $this->prefix_url . 'editMessageReplyMarkup?chat_id='.$chat_id.'&message_id=' . $messageid;
            file_get_contents($exe_url);

        }

    }

