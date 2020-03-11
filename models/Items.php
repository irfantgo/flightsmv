<?php
class Items extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'alerts';
        parent::__construct();
    }

    public function archiveItems()
    {
        $this->conn->where('status', 'send_alert');
        $items = $this->conn->get($this->tablename);

        if( !empty($items) ) {
            foreach( $items as $item ) {
                
                $this->updateStatus( $item['ID'], 'archived' );
                
            }
        }

    }

    public function clearItems()
    {
        $this->conn->where('status', 'send_alert');
        $this->conn->delete($this->tablename);
    }


    /**
     * Update item status
     * @param  int $id
     * @param  string $status
     * @return boolean
     */
    public function updateStatus( $id, $status )
    {

        $this->conn->where('ID', $id);
        if( $this->conn->update($this->tablename, ['status' => $status]) ) {
            return true;
        }

        return false;

    }


}
