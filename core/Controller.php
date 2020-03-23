<?php
/**
 * The main controller file
 */

use Jenssegers\Blade\Blade;
use PHPMailer\PHPMailer\Exception;
use Heliumframework\Auth;

namespace Heliumframework;

abstract class Controller 
{

    private $blade;
    public $formData;
    public $formResponse = [
        'status' => false,
        'errors' => [],
        'error_fields' => [],
        'textMessage' => ''
    ];

    public function __construct()
    { 

        // Unserialize FormData from $_POST['data'] to an array
        if( isset($_POST['data']) ) {
            
            parse_str($_POST['data'], $this->formData);

            // Check whether csrf was set
            if(
                isset($this->formData['csrf']) == false ||
                (isset($this->formData['csrf']) && Session::get('csrf') != $this->formData['csrf']) ||
                \Heliumframework\Session::get('csrf') == false
            ) {
                $this->formResponse['errors'][] = 'Error 419';
                $this->send_json_response();
            }

        }

        // Initialize Blade
        $this->blade = new \Jenssegers\Blade\Blade(dirname(__DIR__).'/views', dirname(__DIR__).'/cache');

    }

    /**
     * Render View
     * @param string $viewname
     * @param array $data
     */
    public function view( $viewname, $data = [] )
    {

        // !! TODO: NEED TO FIND A METHOD TO ERROR HANDLE WHEN VIEW IS NOT FOUND

        // Render View
        echo $this->blade->make($viewname, $data)->render();


    }

    /**
     * Send form data as json
     * @return json
     */
    public function send_json_response()
    {
        echo json_encode($this->formResponse);
        exit; // Do not execute anything further
    }

    /**
     * Authenticate View
     * @param string $permission
     * @return void
     */
    public function viewAuthenticate( $permission )
    {
        if( Auth::hasPermission($permission) == false ) {
            // Show 40# Unauthorised
            error_header(401);
        }
    }

    /**
     * Authenticate whether user has permission
     * @param string $permission
     * @return object
     */
    public function ajaxAuthentication( $permission )
    {
        if( Auth::hasPermission($permission) == false ) {
            $this->formResponse['errors'][] = 'Sorry, you do not have permission to perform this action';
            $this->send_form_data();
        }
    }

    /**
     * Authenticate an application
     * @param string $token
     * @return json
     */
    public function authenticateApp( $token = null )
    {

        $response = [
            'status' => false,
            'message' => 'Invalid request'
        ];

        if( $token == null ) {
            $response['message'] = 'Token not set';
        }
        else {

            if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
                
                // Check for authenticated application
                $appModel = new Model();
                $appModel->conn->where('token', $token);
                $app = $appModel->conn->get('applications');
    
                if( !empty($app) ) {
                    $response = [
                        'status' => true,
                        'message' => 'Application Authenticated'
                    ];
                }
    
            }
            else {

                $response['message'] = 'Invalid Request Method';
                
            }

        }

        if( $response['status'] == false ) {
            echo json_encode($response); exit;
        }

    }

}