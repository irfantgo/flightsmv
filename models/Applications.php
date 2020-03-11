<?php
class Applications extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'auth_apps';  
        parent::__construct();

    }
    

}