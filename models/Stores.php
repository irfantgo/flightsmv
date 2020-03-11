<?php
class Stores extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'stores';
        parent::__construct();

    }

    /**
     * Get all the stores
     * @return array
     */
    public function allStores()
    {
        $records = $this->conn->get( $this->tablename );
        if( $this->conn->count > 0 ) {
            return $records;
        }
        return [];
    }

    /**
     * Get all the stores with its managers
     * @param int $storeid
     * @return array
     */
    public function all_stores_with_managers( $storeid = null )
    {
        $this->conn->join('store_managers sm', 'sm.store_id = stores.ID', 'LEFT');
        $this->conn->join('users u', 'sm.manager_id = u.ID', 'LEFT');
        $records = $this->conn->get( $this->tablename, null, 'u.ID user_id, u.display_name, u.username, stores.*' );
        if( $this->conn->count > 0 ) {
            return $records;
        }
        return [];
    }

    /**
     * Get a store information
     * @param array $param [field | value | operator]
     * @return array
     */
    public function get_a_store( $param )
    {

        $this->conn->where($param[0], $param[1], $param[2]);
        $records = $this->conn->get( $this->tablename );
        if( $this->conn->count > 0 ) {
            return $records;
        }
        return [];

    }

    /**
     * Get all the stores with its managers
     * @param int $storeid
     * @return array
     */
    public function a_store_managers( $storeid )
    {
        $this->conn->join('users u', 'sm.manager_id = u.ID', 'LEFT');
        $this->conn->where('sm.store_id', $storeid);
        $records = $this->conn->get( 'store_managers sm', null, 'u.ID user_id, u.display_name, u.username, u.email' );
        if( $this->conn->count > 0 ) {
            return $records;
        }
        return [];
    }

    /**
     * Get manager's stores
     * @param int $manager_id
     * @return array
     */
    public function get_stores_of_manager( $manager_id )
    {

        $this->conn->join('stores s', 's.ID = sm.store_id', 'INNER');
        $this->conn->where('sm.manager_id', $manager_id);
        $records = $this->conn->get('store_managers sm', null, 's.*, sm.send_alert');

        if( $this->conn->count > 0 ) {
            return $records;
        }

        return [];
    }

    /**
     * Reset store access and alerts for manager
     * @param int $manager_id
     * @return boolean
     */
    public function reset_store_for_manager( $manager_id )
    {
        $this->conn->where('manager_id', $manager_id);
        if( $this->conn->delete('store_managers') ) {
            return true;
        }
        return false;
    }

    /**
     * Clear and dump inventory table
     */
    public function reset_inventory()
    {
        $this->conn->rawQuery('TRUNCATE TABLE stock');
    }

}
