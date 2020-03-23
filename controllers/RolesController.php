<?php
/**
 * Roles Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
class RolesController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null )
    {  

        $rolesModel = new Roles();
        $roles = $rolesModel->get_all_roles();

        $this->view('cpanel.roles.show', ['roles' => $roles]);
    }

    public function create()
    {

        // Authenticate User
        $this->viewAuthenticate( 'MNG_ROLES' );

        $this->view('cpanel.roles.create');
    }

    /**
     * Store New Role Information
     */
    public function store()
    {

        // Authenticate User
        $this->ajaxAuthentication( 'MNG_ROLES' );

        // Authenticate Form
        $form_requirments = [
            'code' => [
                'required' => true,
                'unique' => 'roles',
                'label' => 'Code'
            ],
            'description' => [
                'required' => true,
                'label' => 'Description'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check( $this->formData, $form_requirments );

        // Check whether validation passed
        if( $validation->passed() ) {

            $rolesModel = new Roles();
            $result = $rolesModel->insert([
                'code' => $this->formData['code'],
                'description' => $this->formData['description']
            ]);

            if( $result == true ) {
                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'New Role created';
            }

        }
        // Else, bind all the error fields
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }

        $this->send_json_response();

    }

    /**
     * Show a form to update role 
     */
    public function update( $id = null )
    {

        $this->viewAuthenticate( 'MNG_ROLES' );
        
        $rolesModel = new Roles();
        $role = $rolesModel->find($id);

        // Show 404 if no record was found
        if( empty($role) ) {
            error_header(404);
        }

        $this->view('cpanel.roles.edit', ['role' => $role]);
    }

    /**
     * Update a given record
     */
    public function patch( $id )
    {

        // Authenticate User
        $this->ajaxAuthentication( 'MNG_ROLES' );

        // Authenticate Form
        $form_requirments = [
            'code' => [
                'required' => true,
                'uniquebut' => [
                    'tablename' => 'roles',
                    'primary_key' => 'ID',
                    'primary_key_value' => $id
                ],
                'label' => 'Code'
            ],
            'description' => [
                'required' => true,
                'label' => 'Description'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check( $this->formData, $form_requirments );

        // Check whether validation passed
        if( $validation->passed() ) {

            $rolesModel = new Roles();
            $result = $rolesModel->update( $id, [
                'code' => $this->formData['code'],
                'description' => $this->formData['description']
            ]);

            if( $result == true ) {
                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'Role Update';
            }

        }
        // Else, bind all the error fields
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

        $this->ajaxAuthentication( 'MNG_ROLES' );

        $rolesModel = new Roles();
        if( $rolesModel->delete($id) ) {
            $this->formResponse['status'] = true;
            $this->formResponse['textMessage'] = 'Role removed successfully';
        }


        $this->send_json_response();

    }

}