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
use Heliumframework\Hash;
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
     * Create new user
     */
    public function create()
    {

        // User Authentication
        $this->viewAuthenticate( 'MNG_USERS' );

        // Fetch all groups
        $groupsModel = new Groups();
        $groups = $groupsModel->_get();
        
        // Render View
        $this->view('cpanel.users.create', ['groups' => $groups]);

    }

    /**
     * Store user information
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

            $password = 'News@2020';
            $salt = Hash::salt(35);
            $encPass = Hash::make($password, $salt);

            $verifyCode = uniqid();

            $dbInput = [
                'username' => $this->formData['username'],
                'display_name' => $this->formData['name'],
                'email' => $this->formData['email'],
                'password' => $encPass,
                'salt' => $salt,
                'group_id' => $this->formData['group_id'],
                'verify_code' => $verifyCode,
                'background' => 'background.jpg',
                'dv_name'   => $this->formData['dhi_name'],
                'dv_bio'    => $this->formData['dhi_bio'],
                'en_bio'    => $this->formData['eng_bio']
            ];

            if( $userModel->create($dbInput) ) {

                // TODO: Send an email to user for verification
                // Send Verification code in the email link

                // Send form response
                $this->formResponse = [
                    'status' => true,
                    'textMessage' => 'User created successfully'
                ];

            }
            else {
                $this->formResponse['errors'][] = $userModel->conn->getLastError();
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

        // User Meta Information
        $userMeta = $userModel->get_user_meta( $userid );

        // Fetch all groups
        $groupsModel = new Groups();
        $groups = $groupsModel->_get();

        // Render View
        $this->view('cpanel.users.edit', ['user' => $user, 'user_meta' => $userMeta, 'groups' => $groups]);

    }

    /**
     * Store Updated User Information
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

                $userModel->update_user_meta( $userid, [
                    'dv_name'   => $this->formData['dv_name'],
                    'dv_bio'    => $this->formData['dhi_bio'],
                    'en_bio'    => $this->formData['eng_bio'],
                    'social_media' => $this->formData['social_media']
                ] );

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