<?php
/**
 * Vesalius Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */

use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
class VesaliusController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null )
    {

        $queryModel = new Queries();
        $queries = $queryModel->_get([
            'orderBy' => [
                ['title', 'ASC']
            ]
        ]);

        $this->view('cpanel.vesalius.show', ['queries' => $queries]);
    }

    public function create()
    {

        // Fetch all active recipients
        $recipientsModel = new Recipients();
        $recipients = $recipientsModel->get_all_active_recipients();

        $this->view('cpanel.vesalius.create', ['recipients' => $recipients]);

    }

    /**
     * Store query information
     */
    public function store()
    {

        $formRequirements = [
            'title' => [
                'required' => true,
                'label' => 'Title'
            ],
            'description' => [
                'required' => true,
                'label' => 'Description'
            ],
            'query_statement' => [
                'required' => true,
                'label' => 'Vesalius SQL Query'
            ],
            'start_date' => [
                'required' => true,
                'label' => 'Start Date'
            ],
            'run_time' => [
                'required' => true,
                'label' => 'Run TIme'
            ],
            'interval' => [
                'required' => true,
                'label' => 'Interval'
            ]
        ];

        // Validate
        $errors = [];
        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirements);

        $otherValidation = true;
        if( empty($this->formData['recipients']) ) {
            $otherValidation = false;
            $errors = ['field' => 'recipients', 'message' => 'Please select one or more recipients' ];
        }

        // If validation passed
        if( $validation->passed() && $otherValidation ) {

            // Do mapping of keywords and values

            // Insert information

            // Map recipients and query

        }
        // If form validation failed, then map all the failed fields
        else {

            // Map Form Fields
            $this->formResponse['error_fields'] = $validation->errors();
            if( !empty($errors) ){
                $this->formResponse['error_fields'][] = $errors;
            }

        }


        // Send Response
        $this->send_json_response();

    }

    /**
     * Send results of the query
     */
    public function querytest()
    {

        $errors = [];
        $results = [];

        $sql = $_POST['statement'];
        $vars = (isset($_POST['variables']) ? $_POST['variables'] : []);

        $dataset = [];
        if( !empty($vars) ) {
            foreach( $vars as $v ) { $dataset[$v['key']] = $v['value'];  }
        }

        // Current Date
        $date = date('Y-m-d');

        // Set dataset for the query
        if(!empty($dataset)) {

            foreach( $dataset as $k => $v ) {
    
                // Set Yesterday date
                if( $v == 'YD' ) {
                    $vx =  strtoupper(date('d-M-y',(strtotime( '-1 day' , strtotime($date)))));
                }
    
                // Set Today's date
                if( $v == 'TD' ) {  
                    $vx = strtoupper(date('d-M-y'));
                }
    
                // Set Tomorrow's date
                if( $v == 'TMD' ) {  
                    $vx =  strtoupper(date('d-M-y',(strtotime( '+1 day' , strtotime($date)))));
                }
    
                $sql = str_replace($k, $vx, $sql);
    
            }

        }

        // Execute the query
        $oxconn = oci_connect(_env('REPORT_SCHEMA_USER'), _env('REPORT_SCHEMA_PASS'), _env('REPORT_SCHEMA_HOST').'/'._env('REPORT_SCHEMA_SERV'));

        // Check for valid execution
        if (!$oxconn) {
            $e = oci_error();
            $errors[] = "Unable to make connection to Vesalius." . $e['message'];
        }
        // Continue, execution
        else {

            // Prase query for execution
            $stid = oci_parse($oxconn, $sql);

            // Try execute ox_query and 
            if( !oci_execute($stid) ) {

                $errors[] = "Unable to execute query.";
                $errors[] = "Please check the syntax of the query which was executed.";

            }
            // Continue extracting data from result set
            else {


                $results['message'] = 'Records found';
                $results['rows'] = [];

                $ncols = oci_num_fields($stid);
    
                // Identify columns names
                for ($i = 1; $i <= $ncols; $i++) { $results['column_names'][]  = oci_field_name($stid, $i); }
    
                // Start setting the array from array 1, array 0 has been already set for columns
                $c = 1; 
                
                // Loop all the records
                while( $row = oci_fetch_assoc($stid) ) {
                    $results['rows'][$c] = $row;
                    $c++;
                }

            }

        }

        // Check for results


        // Loop results and 

        // Render View
        $this->view('cpanel.vesalius.query-results', ['results' => $results, 'errors' => $errors, 'query' => $sql]);

    }


}