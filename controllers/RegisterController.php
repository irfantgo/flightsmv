<?php
/**
 * Register Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
class RegisterController extends Controller
{

    public function index( $id = null )
    {

        $this->view('register.show');
    }

    public function create()
    {
        $this->view('home');
    }

    public function store()
    {

        // Form validation

        $form_requirments = [
            'full_name' => [
                'required' => true,
                'label' => 'Full Name'
            ],
            'username' => [
                'required' => true,
                'label' => 'Username',
                'unique' => 'users'
            ],
            'email' => [
                'required' => true,
                'label' => 'Email',
                'unique' => 'users',
                'email_valid' => true
            ],
            'new_password' => [
                'required' => true,
                'label' => 'Password',
                'min' => 3
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $form_requirments);

        // Check if the form passed validation
        if( $validation->passed() ) {

            // Generate a encrypted password
            $salt = Heliumframework\Hash::salt(35);
            $password = Heliumframework\Hash::make($this->formData['new_password'], $salt);
            $verify_code = md5(time());

            $dataset = [
                'username' => strtolower(str_replace(' ', '', $this->formData['username'])),
                'display_name' => $this->formData['full_name'],
                'email' => $this->formData['email'],
                'password' => $password,
                'salt' => $salt,
                'first_loggedIn' => NULL,
                'last_loggedIn' => NULL,
                'group_id' => 1,
                'isActive' => 1,
                'joined_dt' => date('Y-m-d H:i:s'),
                'account_type' => 'Standard Account',
                'req_dealer_acc' => 0,
                'premium_account' => 0,
                'verified' => 0,
                'verify_code' => $verify_code,
                'fb_token' => NULL,
                'tw_token' => NULL,
                'gl_token' => NULL,
            ];

            $user = new Users();
            if( $user->create($dataset) ) {

                // Send Verification Email
                

                // Create a session flag
                Session::put('success_reg', true);

                // Set the success notification
                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'Registeration completed successfully';
                $this->formResponse['data_ns'] = '/register/success';

            }
            // Else, set error notification
            else {
                $this->formResponse['errors'][] = $user->getLastError();
                $this->formResponse['errors'][] = 'Unable to process your request';
            }

        }
        // Else, bind the error fields
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }

        // Send json response
        $this->send_json_response();

    }

    /**
     * Show success screen
     */
    public function success()
    {
        // Check for success flag
        if( Session::exists('success_reg') == false ) {
            redirectTo('/');
        } else {
            Session::delete('success_reg');
        }
        $this->view('register.success');
    }

    public function update( $id = null )
    {

    }

    public function destroy()
    {

    }

}