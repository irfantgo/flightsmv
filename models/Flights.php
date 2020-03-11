<?php
class Flights extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'flightinfo';  
        parent::__construct();

    }

    public function get_all_flights()
    {
        $records = $this->conn->get($this->tablename);

        if( !empty($records) ) {
            return $records;
        }

        return [];
        
    }

    public function get_departure()
    {

    }

    public function get_arrival()
    {

    }

    public function get_all_airlines()
    {

    }
    

}