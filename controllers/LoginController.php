<?php
/**
 * Home Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Notifications;
use Heliumframework\Session;
use Heliumframework\Hash;
use Heliumframework\Controller;
use Heliumframework\Validate;

class LoginController extends Controller
{
    
    public function index( $id = null )
    {

        // Redirect User If logged in
        if( Auth::isLoggedIn() ) {
            redirectTo('/dashboard');
        }

        $this->view('cpanel.login.show');   

    }

    /**
     * Fetch all the user notifications
     */
    public function notifications()
    {

        // Load all the notifications for the user
        $notifications = [
            ['icon' => 'bell', 'msg' => 'Adam Requested for a Dealer Account', 'datetime' => '9 Jan', 'url' => ''],
            ['icon' => 'bell', 'msg' => 'Please update profile', 'datetime' => '9 Jan', 'url' => ''],
            ['icon' => 'bell', 'msg' => 'Please update profile', 'datetime' => '9 Jan', 'url' => ''],
            ['icon' => 'bell', 'msg' => 'Please update profile', 'datetime' => '9 Jan', 'url' => ''],
            ['icon' => 'exclamation-triangle', 'msg' => 'Account Deactivated', 'datetime' => '8 Jan', 'url' => '']
        ];


        Session::put('user_notifications', $notifications);


        // Redirect User to Dashboard
        redirectTo('/dashboard');

    }

    /**
     * Login using the active directory
     */
    public function adlogin()
    {

        /**
         * Few steps to follow
         * ---------------------
         * 1. Login using AD Login credentials
         * 2. Check whether the user is already in the system
         * 3. If user exists, give your the correct roles
         */

        // Form Validation
        $formRequirments = [
            'username' => [
                'required' => true,
                'label' => 'Username'
            ],
            'password' => [
                'required' => true,
                'label' => 'Password'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirments);

        // Check if validation passed
        if( $validation->passed() ) {

            // User authentication by AD
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"http://10.2.2.34/adlogin/index.php");
            curl_setopt($ch, CURLOPT_POST, 1);

            // In real life you should use something like:
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('username' => $this->formData['username'], 'password' => $this->formData['password'])));

            // Receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            curl_close ($ch);

            $result = json_decode($server_output);

            if( $result->status ) {

                // Look up for user
                $userModel = new Users();
                $user = $userModel->username($this->formData['username']);

                // Check whether user is registered and active in inventory system
                if( !empty($user) ) {

                    // Fetch user group information
                    $groupModel = new Groups();
                    $group = $groupModel->find($user['group_id']);

                    // Check whether the user if active
                    if( $user['isActive'] == true ) {

                        // Fetch user's mapped departments
                        $mapped_departments = $userModel->get_mapped_departments( $user['user_id'] );

                        $userSession = [
                            'user_id'       => $user['user_id'],
                            'username'      => $user['username'],
                            'display_name'  => $user['display_name'],
                            'email'         => $user['email'],
                            'bg_image'      => $user['bg_image'],
                            'roles'         => ( $group['group_roles'] == NULL ? [] : explode(':', $group['group_roles']) ),
                            'departments'   => $mapped_departments
                        ];

                        Auth::setUserSession($userSession);

                        // Update only if the first_loggedIn value is NULL
                        if( $user['first_loggedIn'] == NULL ) {
                            $userModel->update_field( $user['user_id'], 'first_loggedIn', date('Y-m-d H:i:s') );
                        }
                        
                        $userModel->update_field( $user['user_id'], 'last_loggedIn', date('Y-m-d H:i:s') );

                        $this->formResponse = [
                            'status' => true,
                            'textMessage' => 'Welcome, ' . $user['display_name'],
                            'data_ns' => '/dashboard'
                        ];

                    }
                    // Else, notify user is in-active
                    else {
                        $this->formResponse['errors'][] = "Your account is in-activate";
                    }

                }
                // Else, notify that user is not found in the system
                else {
                    $this->formResponse['errors'][] = 'User not found in the inventory system';
                }

                
            } else {
                $this->formResponse['errors'][] = 'Invalid username and/or password';
                $this->formResponse['errors'][] = $result->message;
            }

        }
        // Else, send error
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }

        // Output the data
        $this->send_json_response();


    }

    /**
     * Process Login
     */
    public function process()
    {

        $formRequirments = [
            'username' => [
                'required' => true,
                'label' => 'Username'
            ],
            'password' => [
                'required' => true,
                'label' => 'Password'
            ]
        ];
        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirments);

        // Check if form validation passed
        if( $validation->passed() ) {

            $user = new Users();
            $currentUser = $user->username($this->formData['username']);

            if( !empty($currentUser) ) {

                // Fetch user group information
                $groupModel = new Groups();
                $group = $groupModel->find($currentUser['group_id']);

                // Check if passport is correct
                if( $currentUser['password'] == Hash::make($this->formData['password'], $currentUser['salt']) ) {

                    // Check whether the user if active
                    if( $currentUser['isActive'] == true ) {

                        $userSession = [
                            'user_id'       => $currentUser['user_id'],
                            'username'      => $currentUser['username'],
                            'display_name'  => $currentUser['display_name'],
                            'email'         => $currentUser['email'],
                            'roles'         => ( $group['group_roles'] == NULL ? [] : explode(':', $group['group_roles']) )
                        ];

                        Auth::setUserSession($userSession);

                        // Update only if the first_loggedIn value is NULL
                        if( $currentUser['first_loggedIn'] == NULL ) {
                            $user->update_field( $currentUser['ID'], 'first_loggedIn', date('Y-m-d H:i:s') );
                        }
                        
                        $user->update_field( $currentUser['ID'], 'last_loggedIn', date('Y-m-d H:i:s') );

                        $this->formResponse = [
                            'status' => true,
                            'textMessage' => 'Welcome, ' . $currentUser['display_name'],
                            'data_ns' => '/login/notifications'
                        ];

                    }
                    // Else, notify user is in-active
                    else {
                        $this->formResponse['errors'][] = "Your account is de-activated";
                    }

                }
                // Notify invalid password
                else {
                    $this->formResponse['errors'][] = 'Invalid password';
                }


            } else {
                $this->formResponse['errors'][] = 'User not found';
            }

        } 
        // Else, bind the errors
        else {
            // Get the errors
            $this->formResponse['error_fields'] = $validation->errors();
        }       

        
        // Output the data
        $this->send_json_response();


    }

    /**
     * Logout User
     */
    public function logout()
    {
        // Remove User Session
        Session::delete('user');

        // Remove User Notifications
        Session::delete('user_notifications');

        // Redirect to Login Page
        redirectTo('/login');
    }

}