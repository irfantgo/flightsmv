<?php
class Recipients extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'recipients';
        $this->tblEmailer = 'emailer';
        parent::__construct();
    }

    /**
     * Get all active recipients
     * @return array
     */
    public function get_all_active_recipients()
    {
        $this->conn->where('status', 'active');
        $records = $this->conn->get($this->tablename);

        // Check for records
        if( $this->conn->count > 0 ) {
            return $records;
        }

        // Return empty array, if no records found
        return [];
    }

    /**
     * Recipients for the query
     * Get only active recipients
     * @param int $queryid
     * @return array
     */
    public function get_recipients_for_query( $queryid )
    {

        $this->conn->where('e.query_id', $queryid);
        $this->conn->where('r.status', 'active');
        $this->conn->join($this->tablename . ' r', 'r.ID=e.recipient_id');
        $records = $this->conn->get($this->tblEmailer . ' e', null, 'r.*');

        // Check for records
        if( $this->conn->count > 0 ) {
            return $records;
        }

        // Return empty array, if no records found
        return [];

    }


}
