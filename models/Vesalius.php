<?php
class Queries extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'queries';  
        parent::__construct();

    }

    /**
     * Get all the queries for now
     * @return array
     */
    public function get_queries_for_now()
    {

        $time = date("H:i");

        // Execute Query
        // $queries = $this->conn->rawQuery("SELECT * from queries where run_t = '$time'");
        $queries = $this->conn->rawQuery("SELECT * from queries");

        // Check for records
        if( $this->conn->count > 0 ) {
            return $queries;
        }

        // Else, return empty array
        return [];

    }
    

}