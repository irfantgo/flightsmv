<?php
class Documents extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'documents';  
        parent::__construct();
    }

    /**
     * Get all documents for the department
     * @param int $did
     * @return array
     */
    public function get_department_docs( $did )
    {

        $this->conn->join('users u', 'u.ID = d.acknowledged_by', 'LEFT');
        $this->conn->where('d.dept_id', $did);
        $this->conn->orderBy('d.created_dt', 'DESC');
        $documents = $this->conn->get('documents d', null, 'd.*, u.display_name ack_display_name');

        if( !empty($documents) ) {
            return $documents;
        }

        return [];

    }
    
    /**
     * Create new document
     * @param array $dataset
     * @return boolean
     */
    public function create( $dataset )
    {

        $dbInput = [
            'dept_id' => $dataset['dept_id'],
            'doc_name' => $dataset['filename'],
            'doc_path' => $dataset['path'],
            'acknowledged' => 0,
            'acknowledged_by' => 0,
            'acknowledged_dt' => NULL,
            'created_dt' => date('Y-m-d H:i:s')
        ];  

        if( $this->insert($dbInput) ) {
            return true;
        }

        return false;

    }

}