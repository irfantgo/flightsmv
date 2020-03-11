<?php
class Region extends \Heliumframework\Model
{

    protected $tbl_atolls = 'region_atolls';
    protected $tbl_islands = 'region_islands';

    public function __construct()
    {
        $this->tablename = ''; // Not setting a specific table for this model
        parent::__construct();

    }

    /**
     * Get all the Atolls
     * @return array
     */
    public function get_all_atolls()
    {

        $this->conn->orderBy('atoll_name', 'ASC');
        $records = $this->conn->get($this->tbl_atolls);
        if( $this->conn->count > 0 ) {
            return $records;
        }
        return [];

    }
    
    /**
     * Get all the islands with atolls
     * @return array
     */
    public function get_all_islands()
    {



    }

    /**
     * Get an atoll
     * @param int $atoll_id
     * @return array
     */
    public function get_atoll( $atoll_id )
    {
        $this->conn->where('ID', $atoll_id);
        $this->conn->orderBy('atoll_name', 'ASC');
        $record = $this->conn->getOne($this->tbl_atolls);
        if( $this->conn->count > 0 ) {
            return $record;
        }
        return [];
    }

    /**
     * Get all the islands of the give atoll id
     * @param int $atoll_id
     * @return array
     */
    public function get_atoll_islands( $atoll_id )
    {
        $this->conn->where('atoll_id', $atoll_id);
        $this->conn->orderBy('island_name', 'ASC');
        $records = $this->conn->get($this->tbl_islands);
        if( $this->conn->count > 0 ) {
            return $records;
        }
        return [];
    }

}