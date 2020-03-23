<?php
class Flights extends \Heliumframework\Model
{

    // Statuses
    public $statues = [
        'LA' => 'LANDED',
        'CA' => 'CANCELLED',
        'DE' => 'DELAYED',
        'FZ' => 'CLOSED',
        'BO' => 'BOARDING',
        'FC' => 'FINAL CALL',
        'DP' => 'DEPARTED'
    ];

    // Bounds
    public $bounds = [
        'D' => 'Domestic',
        'I' => 'International'
    ];

    // URLS
    public $departure_link      = 'http://www.fis.com.mv/xml/depart.xml';
    public $arrival_link        = 'http://www.fis.com.mv/xml/arrive.xml';
    public $airlines_logo_link  = 'http://fis.com.mv/webfids/images/';

    public function __construct()
    {
        $this->tablename = 'flightinfo';  
        parent::__construct();

    }

    public function get_all_flights()
    {
        $records = $this->conn->get($this->tablename);
        $return_records = [];

        if( !empty($records) ) {

            for( $i=0; $i<count($records); $i++ ) {

                $return_records[$i] = $records[$i];
                
                // Cancelled
                if( $records[$i]['status_int'] == 'CA' ) {
                    $return_records[$i]['status_flag'] = 'badge badge-danger';
                }

                // Delayed
                else if( $records[$i]['status_int'] == 'DE' ) {
                    $return_records[$i]['status_flag'] = 'badge badge-warning';
                }

                // Landed
                else if( $records[$i]['status_int'] == 'LA' ) {
                    $return_records[$i]['status_flag'] = 'badge badge-success';
                }
                
                // Anything Else
                else {
                    $return_records[$i]['status_flag'] = '<em>Status Not Available Yet</em>';
                }

            }

        }

        return $return_records;

    }

    public function get_departure()
    {

    }

    public function get_arrival()
    {

    }

    public function get_all_airlines()
    {

    }
    

}