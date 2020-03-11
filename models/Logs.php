<?php
class Logs extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'logs';  
        parent::__construct();
    }

    /**
     * Get all the logs
     */
    public function get_all_logs()
    {

        $this->conn->orderBy('log_dt', 'DESC');
        $logs = $this->conn->get($this->tablename);
        if( !empty($logs) ) {
            return $logs;
        }

        return [];
    }

    /**
     * Get all the logs
     */
    public function get_top_ten_logs()
    {
        
        $this->conn->orderBy('ID', 'DESC');
        $logs = $this->conn->get($this->tablename, 10);
        if( !empty($logs) ) {
            return $logs;
        }

        return [];
    }
    
    /**
     * Add a new log
     * @param string $remark
     * @param string $log_type
     */
    public function add( $remark, $log_type = 'system_log' )
    {
        $dset = [
            'log_dt' => date('Y-m-d H:i:s'),
            'remark' => $remark,
            'log_type' => $log_type
        ];
        $id = $this->conn->insert($this->tablename, $dset);
        if( $id ) {
            return true;
        }
        return false;
    }

}