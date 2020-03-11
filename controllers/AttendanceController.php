<?php
/**
 * Attendance Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Notifications;
use Heliumframework\Validate;
use Heliumframework\Session;
use Dompdf\Dompdf;

class AttendanceController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null ) 
    {}

    public function attendance( $id = null )
    {

        // Authenticate View
        $this->viewAuthenticate('VIEW_ATTENDANCE');

        // Authenticate HOD
        $this->_authenticateHOD($id);

        $status = false;
        $message = '';
        $html_output = '';

        // Get department
        $departmentModel = new Departments();
        $department = $departmentModel->find($id);

        $view_name = $department['schedule_view'];

        if( empty($view_name) ) {
            $message = 'View not found';
        }
        else {

            // Create new instance of the attendance model
            $att = new Attendance(_env('ATTENDANCE_DB_HOST'), _env('ATTENDANCE_DB_NAME'), _env('ATTENDANCE_DB_USER'), 'SR\=&<<9P3J\'tR"\'?FB*Kc{a@:RSuuq25#Ks--u5*8jH&');
    
            if( empty($att->errors()) ) {
        
                $att->get_view($view_name);
                
                $dataset = $att->something_cleaner();
        
                if( ! empty($dataset) ) {

                    $status = true;
    
                    // Create datasheet
                    $html_output .= $this->_create_datasheet( $dataset );
        
                }
                else {
                    $message = 'No records found';
                }
        
            }
            else {
                $message = 'Error connecting to database';
            }

        }

        $this->view('cpanel.attendance.attendance', ['status' => $status, 'message' => $message, 'department' => $department, 'sheet' => $html_output]);

    }

    /**
     * View all the payload for the department
     * @param int $id ($department ID)
     * @return void
     */
    public function payrolld( $id = null )
    {  

        // Authenticate View
        $this->viewAuthenticate('VIEW_PAYROLL');

        // Authenticate HOD
        $this->_authenticateHOD($id);

        $status = false;
        $message = '';
        $html_output = '';

        // Get department
        $departmentModel = new Departments();
        $department = $departmentModel->find($id);

        $view_name = $department['attendance_view'];

        if( empty($view_name) ) {
            $message = 'View not found';
        }
        else {

            // Create new instance of the attendance model
            $att = new Attendance(_env('ATTENDANCE_DB_HOST'), _env('ATTENDANCE_DB_NAME'), _env('ATTENDANCE_DB_USER'), 'SR\=&<<9P3J\'tR"\'?FB*Kc{a@:RSuuq25#Ks--u5*8jH&');
    
            if( empty($att->errors()) ) {
        
                $att->get_view($view_name);
                
                $dataset = $att->something_cleaner();
        
                if( ! empty($dataset) ) {

                    $status = true;
    
                    // Create datasheet
                    $html_output .= $this->_create_datasheet($dataset);
        
                }
                else {
                    $message = 'No records found';
                }
        
            }
            else {
                $message = 'Error connecting to database';
            }

        }

        $this->view('cpanel.attendance.payroll', ['status' => $status, 'message' => $message, 'department' => $department, 'sheet' => $html_output]);
        
    }

    /**
     * View department documents
     * @param int $did
     * @return void
     */
    public function documents($did)
    {

        // Authenticate View
        $this->viewAuthenticate('VIEW_DOCUMENTS');

        // Authenticate HOD
        $this->_authenticateHOD($did);

        // Get department
        $departmentModel = new Departments();
        $department = $departmentModel->find($did);

        // Fetch department documents
        $documentsModel = new Documents();
        $documents = $documentsModel->get_department_docs($did);

        // Render view
        $this->view('cpanel.attendance.documents', ['department' => $department, 'documents' => $documents]);

    }

    /**
     * Document view
     * @param int $docid
     * @return void
     */
    public function docview( $docid )
    {
         // Authenticate View
         $this->viewAuthenticate('VIEW_DOCUMENTS');

        // Fetch document
        $documentsModel = new Documents();
        $document = $documentsModel->find($docid);

        // Send error header
        if( empty($document) ) {
            error_header( 404 );
        }

        // Authenticate HOD
        $this->_authenticateHOD($document['dept_id']);

        // Check if file exists
        if( ! file_exists($document['doc_path']) ) {
            echo "file not found";
            // error_header( 404 );
        }

        // Render PDF
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=".$document['doc_name']);
        readfile($document['doc_path']);

    }

    /**
     * Acknowledge a document
     * @param int $docid
     * @return object
     */
    public function docack($docid)
    {
        // User Authentication
        $this->ajaxAuthentication( 'ACKNWLEDGE' );

        // Check if document ID was set
        if( isset($docid) ) {

            // Fetch document
            $documentModel = new Documents();
            $document = $documentModel->find($docid);

            // Check for document
            if( empty($document) ) {
                $this->formResponse['errors'][] = 'Requested document not found';
            }
            // Else, continue
            else {

                // Mark document as acknowledged
                $exe = $documentModel->update($docid, [
                    'acknowledged' => 1, 
                    'acknowledged_by' => Session::get('user')['user_id'], 
                    'acknowledged_dt' => date('Y-m-d H:i:s')
                ]);
                    
                // If acknowledge was successful
                if( $exe ) {
                    
                    // Send email to HR


                    // Set the status
                    $this->formResponse['status'] = true;
                    $this->formResponse['textMessage'] = 'Report acknowledged successfully';


                }
                // Else, bind error message
                else {
                    $this->formResponse['errors'][] = 'Unable to acknowledge the report';
                }

            }

        }
        // Else, bind error
        else {
            $this->formResponse['errors'][] = 'Unable to find document';
        }

        // Send Response
        $this->send_json_response();
    }

    /**
     * Generate PDF
     * @param int $did (Department ID)
     * @return object
     */
    public function genpdf($did, $view)
    {

        // Fetch department
        $departmentModel = new Departments();
        $department = $departmentModel->find($did);

        $first_date = '';
        $view_name = '';

        if($view == 'payroll') {
            $view_name = $department['attendance_view'];
        }

        if($view == 'attendance') {
            $view_name = $department['schedule_view'];
        }

        if( $view_name == '' ) {
            error_header(404);
        }

        $blank = '<em>NOT SET</em>';

        // Create new instance of the attendance model
        $att = new Attendance(_env('ATTENDANCE_DB_HOST'), _env('ATTENDANCE_DB_NAME'), _env('ATTENDANCE_DB_USER'), 'SR\=&<<9P3J\'tR"\'?FB*Kc{a@:RSuuq25#Ks--u5*8jH&');
    
        if( empty($att->errors()) ) {
    
            $att->get_view($view_name);
    
            $html_output = '';
            $dataset = $att->something_cleaner();
    
            if( ! empty($dataset) ) {

                // Create datasheet
                $html_output .= $this->_create_datasheet($dataset);

                // Set file settings
                $pdf_dir = dirname(__DIR__) . '/storage/trash/';
                if(!is_dir($pdf_dir)) { mkdir($pdf_dir, 0775, true); }
                $pdf_filename = 'test_'.time().'.pdf';
                $pdf_file = $pdf_dir . $pdf_filename;
                
                // Load PDF Template
                $pdf_template = file_get_contents(dirname(__DIR__) . '/crons/pdf_template.html');
                $pdf_template = str_replace('[::DEPARTMENT_NAME::]', strtoupper($department['name']), $pdf_template);
                $pdf_template = str_replace('[::DATASET::]', $html_output, $pdf_template);
                $pdf_template = str_replace('[::MONTH::]', strtoupper(date('F', strtotime($first_date))), $pdf_template);
                $pdf_template = str_replace('[::YEAR::]', date('Y', strtotime($first_date)), $pdf_template);
    
                // Generate PDF and save
                $dompdf = new Dompdf();
                $dompdf->loadHtml($pdf_template);
    
                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->set_option('defaultFont', 'Courier');

                $dompdf->render();
                $pdf_output = $dompdf->output();
                file_put_contents($pdf_file, $pdf_output);

                // Render PDF
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=".$pdf_filename);
                readfile($pdf_file);
    
            }
            
            redirectTo('/department/documents/'.$department['ID']);
    
        }
        else {
            echo 'An error occured when trying to connect to database';
        }

    }

    /**
     * A view for debugging purpose
     * @param int $did
     * @return void
     */
    public function debugd( $did )
    {

        // User Authentication
        $this->ajaxAuthentication( 'DEBUG_ATTENDANCE' );

        // Authenticate HOD
        $this->_authenticateHOD($did);

        // Get department
        $departmentModel = new Departments();
        $department = $departmentModel->find($did);

        $status = false;
        $message = '';
        $html_output = '';

        $view_name = $department['attendance_view'];

        if( empty($view_name) ) {
            $message = 'View not found';
        }
        else {

            // Create new instance of the attendance model
            $att = new Attendance(_env('ATTENDANCE_DB_HOST'), _env('ATTENDANCE_DB_NAME'), _env('ATTENDANCE_DB_USER'), 'SR\=&<<9P3J\'tR"\'?FB*Kc{a@:RSuuq25#Ks--u5*8jH&');
    
            if( empty($att->errors()) ) {

                $att->get_view($view_name);

                $results = [];
                $c = 0;
                while($row = $att->get_results()) {
                    $results[$c] = $row;
                    $c++;
                }

                // echo '<pre>'; print_r($results); echo '</pre>';


                $dataset = $att->something_cleaner();

                echo '<pre>'; print_r($dataset); echo '</pre>';
                exit;
        
                if( ! empty($dataset) ) {

                    $status = true;
        
                }
                else {
                    $message = 'No records found';
                }
        
            }
            else {
                $message = 'Error connecting to database';
            }

        }

        //  Render View
        $this->view('cpanel.attendance.debug', ['status' => $status, 'message' => $message, 'department' => $department, 'results' => $results, 'dataset' => $dataset]);

    }

    /**
     * Authenticate HOD
     * @param int $did (Department ID)
     * @return boolean
     */
    public function _authenticateHOD($did)
    {
        $r = false;
        $hod_departments = Session::get('user')['departments'];
        foreach( $hod_departments as $dept ) {
            if( $dept['ID'] == $did ) {
                $r = true;
            }
        }

        // Show 401 error if not authorised
        if( $r == false ){
            error_header(401);
        }

    }

    /**
     * Create a datasheet
     * @param array $dataset
     * @return string
     */
    public function _create_datasheet( $dataset )
    {
        $total_weeks    = 5;
        $nextStart      = 0;
        $oldRow         = false;
        $html_output    = '';
        $blank          = '<em>NOT SET</em>';

        $html_output .= '<table style="font-size: 7pt; font-family: arial;" width="50%" border="1" rules="all">';
    
        $html_output .= '<tr>';
        $html_output .= '<th>STAFF NAME</th>';
        $html_output .= '<th style="text-align: center;" >HOURS SCHEDULED</th>';
        $html_output .= '<th style="text-align: center;" >HOURS WORKED</th>';
        // $html_output .= '<th style="text-align: center;" >HOURS OVERTIME</th>';
        $html_output .= '</tr>';

        foreach( $dataset as $person => $data ) {

            $hs = 0;
            $ot = 0;
            $wt = 0;

            // Calculation
            foreach( $data as $info ) {
                $hs = $hs + $info['TOTAL_SCHEDULED_HOUR'];
                // $ot = $ot + $info['TOTAL_OT_HOUR'];
                $wt = $wt + $info['TOTAL_WORK_HOUR'];
            }

            $html_output .= '<tr>';
            $html_output .= '<td>'.$person.'</td>';
            $html_output .= '<td style="text-align: center;">'.$hs.'</td>';
            $html_output .= '<td style="text-align: center;">'.$wt.'</td>';
            // $html_output .= '<td style="text-align: center;">'.$ot.'</td>';
            $html_output .= '</tr>';
        }
        $html_output .= '</table><br>';

        for( $w=1; $w<=$total_weeks; $w++ ) {

            $html_output .= '<table style="font-size: 7pt;" width="100%" border="1" rules="all">';

            // Date
            $html_output .= '<tr>';
            $html_output .= '<td width="20%"></td>';
            foreach( $dataset as $emp_name => $timing ) {

                // Set first date, this is for flagging the MONTH and YEAR for the report title
                $first_date = $timing[0]['SCHDEULE_DATE'];

                if( $oldRow == false ){
                    for( $i=$nextStart; $i<($nextStart + 7); $i++ ) {
                        $html_output .= '<th style="text-align: center;" colspan="2" width="10%">';
                        $html_output .= ( !empty($timing[$i]) ? $timing[$i]['SCHDEULE_DATE'] : $blank);
                        $html_output .= '</th>';
                    }
                    $oldRow = true;
                }
            }
            $html_output .= '</tr>';

            $oldRow = false;

            // Day
            $html_output .= '<tr>';
            $html_output .= '<td width="20%"></td>';
            foreach( $dataset as $emp_name => $timing ) {
                if( $oldRow == false ){
                    for( $i=$nextStart; $i<($nextStart + 7); $i++ ) {
                        $html_output .= '<th style="text-align: center;" colspan="2" width="10%">';
                        $html_output .= ( !empty($timing[$i]) ? 'Day-'.($i + 1) : $blank);
                        $html_output .= '</th>';
                    }
                    $oldRow = true;
                }
            }
            $html_output .= '</tr>';

            $oldRow = false;

            // Lables
            $html_output .= '<tr>';
            $html_output .= '<td width="20%"></td>';
            foreach( $dataset as $emp_name => $timing ) {
                if( $oldRow == false ){
                    for( $i=$nextStart; $i<($nextStart + 7); $i++ ) {
                        $html_output .= '<th style="text-align: center;" width="5%">Scheduled</th>';
                        $html_output .= '<th style="text-align: center;" width="5%">Actual</th>';
                    }
                    $oldRow = true;
                }
            }
            $html_output .= '</tr>';

        
            // All Data and Timing
            foreach( $dataset as $emp_name => $timing ) {

                $html_output .= '<tr>';
                $html_output .= '<td width="20%">'.$emp_name.'</td>';

                for( $i=$nextStart; $i<($nextStart + 7); $i++ ) {
                    $html_output .= '<td style="text-align: center;" style="text-align: center;" width="5%">';
                    $html_output .= $timing[$i]['SCH_DISPLAY_LABEL'];
                    $html_output .= '</td>';
                    $html_output .= '<td style="text-align: center;" style="text-align: center;" width="5%">';
                    $html_output .= $timing[$i]['ACT_DISPLAY_LABEL'];
                    $html_output .= '</td>';
                }

                $html_output .= '</tr>';
            
            }
    
            $html_output .= '</table>';
            $html_output .= '<br>';

            $nextStart = $nextStart + 7;
            $oldRow = false;

        }

        return $html_output;
    }

}

