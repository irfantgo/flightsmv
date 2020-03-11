<?php
/**
 * Users Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
use Svg\Tag\Group;

class UsersController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null )
    {  

        $this->viewAuthenticate( 'MNG_USERS' );

        $userModel = new Users();
        $users = $userModel->all_users();

        $this->view('cpanel.users.show', ['users' => $users]);
        
    }

    /**
     * Create new store keeper
     */
    public function create()
    {

        // User Authentication
        $this->viewAuthenticate( 'MNG_USERS' );

        // Fetch all groups
        $groupsModel = new Groups();
        $groups = $groupsModel->_get();

        // Fetch all departments
        $departmentsModel = new Departments();
        $departments = $departmentsModel->_get([
            'andWhere' => [
                ['isActive', '1', '=']
            ]
        ]);
        
        // Render View
        $this->view('cpanel.users.create', ['departments' => $departments, 'groups' => $groups]);

    }

    /**
     * Store New Staff Information
     */
    public function store()
    {

        // User Authentication
        $this->ajaxAuthentication( 'MNG_USERS' );

        // Validation
        $formRequirements = [
            'name' => [
                'required' => true,
                'label' => 'Name'
            ],
            'username' => [
                'required' => true,
                'unique' => 'users',
                'label' => 'Username'
            ],
            'email' => [
                'required' => true,
                'unique' => 'users',
                'label' => 'Email'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirements);

        // Check if form passed validation
        if( $validation->passed() ) {

            $userModel = new Users();

            $dbInput = [
                'username' => $this->formData['username'],
                'display_name' => $this->formData['name'],
                'email' => $this->formData['email'],
                'contact_no' => '',
                'password' => '',
                'salt' => '',
                'group_id' => $this->formData['group_id'],
                'first_loggedIn' => NULL,
                'last_loggedIn' => NULL,
                'isActive' => 1,
                'joined_dt' => date('Y-m-d H:i:s'),
                'background' => 'background.jpg'
            ];

            if( $userModel->create($dbInput) ) {

                $lastRecordId = $userModel->last_record_id;

                // Map all departments
                if( !empty($this->formData['departments']) ) {
                    $userModel->map_departments($lastRecordId, $this->formData['departments']);
                }

                $this->formResponse = [
                    'status' => true,
                    'textMessage' => 'New user created successfully'
                ];

            }
            else {
                $this->formResponse['errors'][] = 'Unable to create new user';
            }

        }
        // Else, bind errors fields
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }

        // Send Response
        $this->send_json_response();

    }

    /**
     * Edit User Information
     * @param int $userid
     */
    public function update( $userid ) 
    {

        // Authenticate user
        $this->viewAuthenticate( 'MNG_USERS' );

        // Fetch the user 
        $userModel = new Users();
        $user = $userModel->find($userid);

        // 404
        if( empty($user) ) {
            error_header(404);
        }

        // Fetch all groups
        $groupsModel = new Groups();
        $groups = $groupsModel->_get();

        // Fetch user's departments
        $userDepartmentsRecords = $userModel->get_mapped_departments($userid);
        $userDepartments['dept_id'] = [];
        $userDepartments['send_mail'] = [];
        $c = 0;
        if( !empty($userDepartmentsRecords) ) {
            foreach( $userDepartmentsRecords as $peh ) {
                $userDepartments['dept_id'][$c] = $peh['ID'];
                if( $peh['send_mail'] == 1 ) {
                    $userDepartments['send_mail'][$c] = $peh['ID'];
                }
                $c++;
            }
        }

        // Fetch all departments
        $departmentsModel = new Departments();
        $departments = $departmentsModel->_get([
            'andWhere' => [
                ['isActive', '1', '=']
            ]
        ]);

        // Render View
        $this->view('cpanel.users.edit', ['user' => $user, 'departments' => $departments, 'mapped_depts' => $userDepartments, 'groups' => $groups]);

    }

    /**
     * Store Updated Staff Information
     * @param int $userid
     */
    public function patch( $userid )
    {

        // User Authentication
        $this->ajaxAuthentication( 'MNG_USERS' );

        // Validation
        $formRequirements = [
            'name' => [
                'required' => true,
                'label' => 'Name'
            ],
            'username' => [
                'required' => true,
                'uniquebut' => [
                    'tablename' => 'users',
                    'primary_key' => 'ID',
                    'primary_key_value' => $userid
                ],
                'label' => 'Username'
            ],
            'email' => [
                'required' => true,
                'uniquebut' => [
                    'tablename' => 'users',
                    'primary_key' => 'ID',
                    'primary_key_value' => $userid
                ],
                'label' => 'Email'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirements);

        // Check if form passed validation
        if( $validation->passed() ) {

            $userModel = new Users();

            $dbInput = [
                'username' => $this->formData['username'],
                'display_name' => $this->formData['name'],
                'email' => $this->formData['email'],
                'group_id' => $this->formData['group_id'],
                'isActive' => ( isset($this->formData['isActive']) ? 1  : 0)
            ];

            if( $userModel->update( $userid, $dbInput) ) {

                $rr = [
                    'test' => 'woo',
                    'abc' => 'wooo'
                ];

                // Update departments
                $userModel->update_map_departments($userid, $this->formData['departments']);

                $this->formResponse = [
                    'status' => true,
                    'textMessage' => 'User Information updated successfully'
                ];

            }
            else {
                $this->formResponse['errors'][] = 'Unable to update user';
            }

        }
        // Else, bind errors fields
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }

        // Send Response
        $this->send_json_response();

    }


}