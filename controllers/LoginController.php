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
            redirectTo('/admin/dashboard');
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
        redirectTo('/admin/dashboard');

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

                    // Check whether the user if active and verified
                    if( $currentUser['isActive'] == true && $currentUser['isVerified'] == true ) {

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
                            'data_ns' => '/dashboard'
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
        redirectTo(_env('LOGIN_URL'));
    }

    public function checksession()
    {
        if( Session::exists('user') ) {
            echo true;
        }
        echo false;
    }

}