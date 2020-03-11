<?php
class Roles extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'roles';
        parent::__construct();
    }

    /**
     * Get all roles
     */
    public function get_all_roles()
    {
        $records = $this->conn->get($this->tablename);
        if( $this->conn->count > 0 ) {
            return $records;
        }
        return [];
    }
    

}