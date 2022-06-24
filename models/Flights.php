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
        // $this->conn->orderBy('ID', 'DESC');
        $today = date('Y-m-d');
        $this->conn->where('scheduled_d', $today, '>=');
        $records = $this->conn->get($this->tablename);
        $return_records = [];

        if( !empty($records) ) {

            for( $i=0; $i<count($records); $i++ ) {

                $tday = $records[$i]['scheduled_d'];
                $direction = $records[$i]['direction'];

                $return_records[$tday][$direction][$i] = $records[$i];
                
                // Cancelled
                if( $records[$i]['status_int'] == 'CA' ) {
                    $return_records[$tday][$direction][$i]['status_flag'] = 'badge badge-danger';
                }

                // Delayed
                else if( $records[$i]['status_int'] == 'DE' ) {
                    $return_records[$tday][$direction][$i]['status_flag'] = 'badge badge-warning';
                }

                // Landed
                else if( $records[$i]['status_int'] == 'LA' ) {
                    $return_records[$tday][$direction][$i]['status_flag'] = 'badge badge-success';
                }

                // Departed
                else if( $records[$i]['status_int'] == 'DP' ) {
                    $return_records[$tday][$direction][$i]['status_flag'] = 'badge badge-success';
                }
                
                // Anything Else
                else {
                    $return_records[$tday][$direction][$i]['status_flag'] = '<em>Status Not Available Yet</em>';
                }

            }

        }

        return $return_records;

    }

    public function select_flight_by_id( $flightId )
    {
        $this->conn->where('ID', $flightId);
        return $this->conn->getOne($this->tablename);
    }

    public function select_flight_by_no( string $flightNo )
    {
        $this->conn->where('flight_no', $flightNo);
        return $this->conn->getOne($this->tablename);
    }

    public function find_flight_by_no( string $flightNo )
    {
        $today = date('Y-m-d');
        $this->conn->where('scheduled_d', $today, '>=');
        $this->conn->where('flight_no', $flightNo);
        return $this->conn->get($this->tablename);
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