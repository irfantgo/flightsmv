<?php
class Groups extends \Heliumframework\Model
{

    public function __construct()
    {
        parent::__construct();
        $this->tablename = 'user_groups';
    }
    

}