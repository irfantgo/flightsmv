<?php
/**
 * Regions Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
class RegionsController extends Controller
{

    protected $regionResponse;

    public function __construct()
    {
        parent::__construct();
        $this->regionResponse = [
            'status' => false,
            'textMessage' => 'Invalid request',
            'dataset' => []
        ];
    }

    /**
     * Return information of all the atolls and it's islands
     * @return json
     */
    public function atolls()
    {
        // To handle later
    }

    /**
     * Returns information about an individual atoll and it's islands
     * @param int $atoll_id
     * @return json
     */
    public function atoll( $atoll_id )
    {

        $atollModel = new Region();
        $atoll = $atollModel->get_atoll($atoll_id);

        if( !empty($atoll) ) {

            $this->regionResponse['status'] = true;
            $this->regionResponse['textMessage'] = '';
            $this->regionResponse['dataset']['atoll'] = $atoll;

            // Fetch all the islands of the atoll
            $islandModel = new Region();
            $islands = $islandModel->get_atoll_islands($atoll_id);

            if( !empty($islands) ) {
                $this->regionResponse['dataset']['atoll']['islands'] = $islands;
            }

        }

        // Send Information
        $this->_send_data();

    }


    /**
     * Send response
     * @return json
     */
    private function _send_data()
    {
        echo json_encode($this->regionResponse);
        exit;
    }

}