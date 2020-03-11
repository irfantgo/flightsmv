<?php
class Stock extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'stock';  
        parent::__construct();

    }

    /**
     * Get store items for the given store
     * @param int $store_id
     * @return array
     */
    public function get_items( $store_id )
    {

        $records = $this->_get([
            'andWhere' => [
                ['store_id', $store_id, '=']
            ]
        ]);

        if( !empty($records) ) {
            return $records;
        }

        return [];

    }

    /**
     * Get details of a store item
     * @param int $itemid
     * @return array
     */
    public function get_store_item( $itemid )
    {

        $records = $this->_get([
            'andWhere' => [
                ['ID', $itemid, '=']
            ]
        ]);

        if( !empty($records) ) {
            return $records;
        }

        return [];

    }
    

}