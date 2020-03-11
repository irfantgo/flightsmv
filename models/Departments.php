<?php
class Departments extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'departments';
        parent::__construct();
    }

    /**
     * Get department HODS
     * @param int $department_id
     * @return array
     */
    public function get_department_hods( $department_id )
    {

        $this->conn->join('department_map dm', 'dm.user_id = u.ID', 'LEFT');
        $this->conn->where('dm.dept_id', $department_id);
        $this->conn->where('dm.send_mail', '1');
        $this->conn->where('u.isActive', '1');
        $records = $this->conn->get('users u', null, 'u.*');

        if( !empty($records) ) {
            return $records;
        }

        return [];

    }

}
