<?php
/**
 * Applications Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Notifications;
use Heliumframework\Validate;
class ApplicationsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null )
    {  

        $appModel = new Applications();
        $applications = $appModel->_get();

        if( empty($applications) ) {
            error_header(404);
        }

        $this->view('cpanel.applications.show', ['applications' => $applications]);
        
    }

    public function create()
    {

        // Authenticate User
        $this->viewAuthenticate( 'CR_APPS' ); 

        $this->view('cpanel.applications.create');
    }

    /**
     * Store New Role Information
     */
    public function store()
    {

        // Authenticate User
        $this->ajaxAuthentication( 'CR_APPS' );

        $form_requirements = [
            'app_name' => [
                'required' => true,
                'label' => 'Application Name'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $form_requirements);

        // Check if validation passed
        if( $validation->passed() ) {

            $dbInput = [
                'app_name' => $this->formData['app_name'],
                'token_no'=> md5(time())
            ];

            $groupsModel = new Applications();
            if( $groupsModel->insert($dbInput) ) {
                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'New application created';
            } else {
                $this->formResponse['errors'][] = 'Unable to create new application';
            }

        }
        // Else, bind error fields
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }

        $this->send_json_response();

    }

    /**
     * Remove destroy
     */
    public function destroy($id)
    {

        $appModel = new Applications();
        if( $appModel->delete($id) ) {
            Notifications::set('Application removed successfully', 'alert-success');
            redirectTo('/applications');
        }

    }

}