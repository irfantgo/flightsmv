<?php
/**
 * MODEL : DATABASE
 * @author Ahmed Shan (@thaanu16)
 */
namespace Heliumframework;
class Model
{

    public $conn;
    public $tablename;
    public $errors;
    public $last_record_id;

    public function __construct()
    {
        $this->conn = new \MysqliDb (_env('DB_HOST'), _env('DB_USER'), _env('DB_PASS'), _env('DB_NAME'));
    }

    /**
     * Find a record from the given table name
     * @param int $id
     * @return array
     */
    public function find( $id )
    {
        
        $this->conn->where('ID', $id);
        $records = $this->conn->getOne($this->tablename);

        if( $this->conn->count > 0 ) {
            return $records;
        }

        // Set error
        $this->errors[] = $this->conn->getLastError();

        return [];

    }

    /**
     * Temporarily not using 
     * !! Need to see a better way
     */
    public function _get($clauses = [] )
    {

        // Check for and where clauses
        if( isset($clauses['andWhere']) ) {
            foreach( $clauses['andWhere'] as $c ) {
                $this->conn->where($c[0], $c[1], $c[2]);
            }
        }

        // Check for or where clauses
        if( isset($clauses['orWhere']) ) {
            foreach( $clauses['orWhere'] as $c ) {
                $this->conn->orWhere($c[0], $c[1], $c[2]);
            }
        }

        if( isset($clauses['orderBy']) ) {
            foreach( $clauses['orderBy'] as $c ) {
                $this->conn->orderBy($c[0], $c[1]);
            }
        }
        
        // Execute
        $records = $this->conn->get($this->tablename);

		// Check for returned rows
		if( $this->conn->count > 0 ) {
            return $records;
        }

        // Set error
        $this->errors[] = $this->conn->getLastError();
        
        return [];

    }

    /**
     * Insert new record to the database
     * @param array $dataset
     * @return boolean
     */
    public function insert( $dataset )
    {

        $last_record_id = $this->conn->insert( $this->tablename, $dataset );

        if( $last_record_id  ) {
            $this->last_record_id = $last_record_id;
            return true;
        }
        
        // Set error
        $this->errors[] = $this->conn->getLastError();

        return false;

    }

    /**
     * Update record from the database
     * @param int $id
     * @param array $dataset
     * @return boolean
     */
    public function update( $id, $dataset )
    {

        $this->conn->where('ID', $id);

        if( $this->conn->update( $this->tablename, $dataset )  ) {
            return true;
        }
        
        // Set error
        $this->errors[] = $this->conn->getLastError();

        return false;

    }

    /**
     * Delete database record
     * @param int $id
     * @return boolean
     */
    public function delete( $id )
    {

        $this->conn->where('ID', $id);

        if( $this->conn->delete($this->tablename, $id) ) {
            return true;
        }

        return false;

    }

    /**
     * Get the last sql error
     * @return string
     */
    public function getLastError()
    {
        return $this->errors;
    }

}