<?php
/**
 * Flight Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */

use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
class FlightsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null )
    {

        // Render View
        $this->view('cpanel.flights.show');

    }

    /**
     * Fetch flight information (AJAX call)
     */
    public function flightinfo()
    {

        $flightsModel = new Flights();
        $flights = $flightsModel->get_all_flights();

        // Render View
        $this->view('cpanel.flights.info', [
            'dataset' => $flights
        ]);

    }

    /**
     * Create new product
     */
    public function create()
    {

    }

    /**
     * Store product information
     */
    public function store()
    {

    }

    /**
     * Update product information
     * @param int $product_id
     */
    public function update( $product_id )
    {

    }


}