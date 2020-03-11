<?php
/**
 * API Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Notifications;
use Heliumframework\Validate;
class ApiController extends Controller
{

    protected $response = [];

    public function __construct()
    {
        parent::__construct();

        // Handle Authentication
        $headers = apache_request_headers();

        // Check if 

        if( isset($headers['authentication']) ) {

            // Check for token number
            $appModel = new Applications();
            $client = $appModel->_get([
                'andWhere' => [
                    ['token_no', $headers['authentication'], '=']
                ]
            ]);

            if( empty($client) ) {
                $this->_send_unathorised_response('Unauthorised');
            }
           
        } else {
            $this->_send_unathorised_response('Client not found');
        }

    }

    public function index()
    {}

    /**
     * Get all the blood groups
     * @return json
     */
    public function bloodgroups()
    {
        http_response_code(200);
        $this->response['status'] = 200;
        $this->response['data'] = [];

        $bloodModel = new Bloodgroups();
        $groups = $bloodModel->_get();

        $this->response['data']['blood_groups']['count'] = count($groups);
        
        if( empty($groups) ) : $this->response['data']['blood_groups']['data'] = []; else :
            $this->response['data']['blood_groups']['data'] = $groups;
        endif;

        // Send response
        $this->_send_response();
    }

    /**
     * Get donors of the given blood group
     * @param string $bld_init
     * @return json
     */
    public function donors( $bld_init )
    {
        http_response_code(200);
        $this->response['status'] = 200;
        $this->response['data'] = [];

        $bloodModel = new Bloodgroups();
        $bloodGroup = $bloodModel->_get([
            'andWhere' => [
                ['blood_init', $bld_init, '=']
            ]
        ]);

        if( !empty($bloodGroup) ) {
            $this->response['data']['blood_group'] = $bloodGroup;

            // Fetch eligible donors
            $availabilityModel = new Availability();
            $eligible_donors = $availabilityModel->get_eligible_donors($bloodGroup[0]['ID']);
            $this->response['data']['eligible_donors']['count'] = count($eligible_donors);
            $this->response['data']['eligible_donors']['message'] = 'These donors are eligible to donate blood';
            $this->response['data']['eligible_donors']['data'] = ( empty($eligible_donors) ? [] : $eligible_donors );

            // Fetch all donors for the selected blood group
            $userModel = new Users();
            $donors = $userModel->all_users_by_blood_group( $bloodGroup[0]['ID'] );
            $this->response['data']['donors']['count'] = count($donors);
            $this->response['data']['donors']['message'] = 'These donors may or may not be eligible to donate blood';
            
            if( empty($donors) ) : $this->response['data']['donors']['data'] = []; else :

                $cc = 0;
                foreach( $donors as $donor ) {
                    $this->response['data']['donors']['data'][$cc]['ID'] = $donor['user_id'];
                    $this->response['data']['donors']['data'][$cc]['fullname'] = $donor['display_name'];
                    $this->response['data']['donors']['data'][$cc]['contact_no'] = $donor['contact_no'];
                    $this->response['data']['donors']['data'][$cc]['email'] = $donor['email'];
                    $this->response['data']['donors']['data'][$cc]['blood_group']['init'] = $donor['blood_init'];
                    $this->response['data']['donors']['data'][$cc]['blood_group']['name'] = $donor['blood_name'];

                    $cc++;
                }

            endif;
            

        }

        $this->_send_response();
    }

    /**
     * Send Unauthorized Message
     * @param string $msg
     * @return void;
     */
    private function _send_unathorised_response( $msg )
    {
        http_response_code(401);
        $this->response['status'] = 401;
        $this->response['error'] = $msg;
        $this->_send_response();
        exit;
    }

    private function _send_response()
    {
        header('Content-Type: application/json');
        echo json_encode($this->response);
    }
    

}