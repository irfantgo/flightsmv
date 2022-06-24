<?php
class Reminders extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'tbl_reminders';  
        parent::__construct();
    }

    public function set( int $flightId, string $currentStatus, string $chatId )
    {
        $dataset = [
            'flight_id' => $flightId,
            'current_status' => $currentStatus,
            'telegram_chat_id' => $chatId,
            'stop_reminder' => 0,
            'scheduled_dt' => date('Y-m-d H:i:s')
        ];
    }

    public function get( $reminderId )
    {
        $this->conn->where('reminder_id', $reminderId);
        return $this->conn->getOne($this->tablename);
    }

    public function check( int $id, string $chatId)
    {
        $this->conn->where('flight_id', $id);
        $this->conn->where('telegram_chat_id', $chatId);
        $this->conn->where('stop_reminder', 0);
        $this->conn->get($this->tablename);
        return ( $this->conn->count > 0 ? true : false );
    }

    public function getPending()
    {
        $this->conn->where('stop_reminder', 0);
        return $this->conn->get($this->tablename);
    }
    

}