<?php

use Heliumframework\Session;

class Advertisements extends \Heliumframework\Model
{

    public function __construct()
    {

        $this->tablename = 'advertisements';  
        parent::__construct();

    }

    /**
     * Add new advertisements
     * @param string $title
     * @param string $expiry | Default to NULL
     * @param string $desktop_ad
     * @param string $mobile_ad
     * @param string $location
     * @return boolean
     */
    public function new_ad( $title, $expiry, $desktop_ad, $mobile_ad, $location )
    {

        $exe = $this->insert([
            'title'         => $title,
            'expiry'        => $expiry,
            'desktop_ad'    => $desktop_ad,
            'mobile_ad'     => $mobile_ad,
            'published'     => true,
            'location'      => $location
        ]);

        return ( $exe ? true : false );

    }
    

}