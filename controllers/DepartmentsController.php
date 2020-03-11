<?php
/**
 * Departments Controller
 * @author Ahmed Shan (@thaanu16)
 *
 */
use \Dompdf\Dompdf;
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
class DepartmentsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index()
    {

        // Authenticate View
        $this->viewAuthenticate('MNG_DEPTS');

        $departmentsModel = new Departments();
        $departments = $departmentsModel->_get();

        // Render View
        $this->view('cpanel.departments.show', ['departments' => $departments]);

    }

    /**
     * Create new recipients
     * @return void
     */
    public function create()
    {

        // Authenticate View
        $this->viewAuthenticate('MNG_DEPTS');

        // Render view
        $this->view('cpanel.departments.create');

    }

    /**
     * Store recipients information
     * @return json
     */
    public function store()
    {

        // Authenticate View
        $this->ajaxAuthentication('MNG_DEPTS');

        $formRequirments = [
            'name' => [
                'required' => true,
                'unique' => 'departments',
                'label' => 'Name'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirments);

        if( $validation->passed() ) {

            $dbInput = [
                'name' => $this->formData['name'],
                'email' => $this->formData['email'],
                'attendance_view' => $this->formData['attendance_view'],
                'schedule_view' => $this->formData['schedule_view'],
                'isActive' => 1
            ];

            $departmentsModel = new Departments();

            if( $departmentsModel->insert($dbInput) ) {

                $this->formResponse = [
                    'status' => true,
                    'textMessage' => 'Department created successfully'
                ];

            }
            else {
                $this->formResponse['errors'][] = 'Unable to create department';
            }

        }
        // Else, bind error fields
        else {
            $this->formResponse['error_fields'] = $validate->errors();
        }

        // Send JSON Response
        $this->send_json_response();

    }

    public function update( $id = null )
    {

        // Authenticate View
        $this->viewAuthenticate('MNG_DEPTS');

        // Fetch the select recipient
        $departmentsModel = new Departments();
        $department = $departmentsModel->find($id);

        if( empty($department) ) {
            error_header('404');
        }

        // Render View
        $this->view('cpanel.departments.edit', ['department' => $department]);

    }

    /**
     * Update given recipient
     * @param  int $id
     * @return json
     */
    public function patch( $id )
    {

        // Authenticate View
        $this->ajaxAuthentication('MNG_DEPTS');

        $formRequirments = [
            'name' => [
                'required' => true,
                'uniquebut' => [
                    'tablename' => 'departments',
                    'primary_key' => 'ID',
                    'primary_key_value' => $id
                ],
                'label' => 'Name'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirments);

        if( $validation->passed() ) {

            $dbInput = [
                'name' => $this->formData['name'],
                'email' => $this->formData['email'],
                'attendance_view' => $this->formData['attendance_view'],
                'schedule_view' => $this->formData['schedule_view'],
                'isActive' => (isset($this->formData['isActive']) ? 1 : 0)
            ];

            $departmentsModel = new Departments();

            if( $departmentsModel->update($id, $dbInput) ) {

                $this->formResponse = [
                    'status' => true,
                    'textMessage' => 'Department updated successfully'
                ];

            }
            else {
                $this->formResponse['errors'][] = 'Unable to update deparment';
            }

        }
        // Else, bind error fields
        else {
            $this->formResponse['error_fields'] = $validate->errors();
        }

        // Send JSON Response
        $this->send_json_response();

    }

    public function destroy()
    {

    }

}
