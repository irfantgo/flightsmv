<?php
/**
 * Users Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

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

            $password = uniqid();
            $salt = Hash::salt(35);
            $encPass = Hash::make($password, $salt);

            $verifyCode = uniqid();

            $dbInput = [
                'username'      => $this->formData['username'],
                'display_name'  => $this->formData['name'],
                'email'         => $this->formData['email'],
                'password'      => $encPass,
                'salt'          => $salt,
                'group_id'      => $this->formData['group_id'],
                'verify_code'   => $verifyCode,
                'background'    => 'background.jpg',
                'dv_name'       => $this->formData['dhi_name'],
                'dv_bio'        => $this->formData['dhi_bio'],
                'en_bio'        => $this->formData['eng_bio'],
                'social_media'  => $this->formData['social_media']
            ];

            if( $userModel->create($dbInput) ) {

                // HTML Body
                $html_body = '<html><body>';
                $html_body .= '<p>Dear, '.$this->formData['name'].',</p>';
                $html_body .= '<p>Please find the information below to gain access to your account. Before doing so, please verify your account using the link below.</p>';
                $html_body .= '<p>'._env('ABS_PATH').'admin/login/verify/'.$verifyCode.'</p>';
                $html_body .= '<p>Username: '.$this->formData['username'].'</p>';
                $html_body .= '<p>Password: '.$password.'</p>';
                $html_body .= '<p>URL: <a href="'._env('ABS_PATH').'/admin">Login URL</a></p>';
                $html_body .= '</body></html>';

                // Send Verification Email
                // TODO: Make it a cronjob in production
                $this->_send_email($this->formData['email'], $this->formData['name'], 'Account Verification by ' . _env('APP_NAME'), $html_body);

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
                    'dv_name'       => $this->formData['dv_name'],
                    'dv_bio'        => $this->formData['dhi_bio'],
                    'en_bio'        => $this->formData['eng_bio'],
                    'social_media'  => $this->formData['social_media']
                ] );

                $this->formResponse = [
                    'status'        => true,
                    'textMessage'   => 'User Information updated successfully'
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

    /**
     * Reset password
     * @param int $userid
     */
    public function resetpassword( $userid )
    {

        // Authenticate
        $this->ajaxAuthentication('MNG_USERS');

        // Find user
        $userModel = new Users();
        $user = $userModel->find($userid);

        if( empty($user) ) {
            $this->formResponse['errors'][] = 'User not found';
        }
        else {

            $password   = uniqid();
            $salt       = Hash::salt(35);
            $encPass    = Hash::make($password, $salt);
    
            // HTML Body
            $html_body = '<html><body>';
            $html_body .= '<p>Dear, '.$user['display_name'].',</p>';
            $html_body .= '<p>Please find the information below to gain access to your account. Before doing so, please verify your account using the link below.</p>';
            $html_body .= '<p>Username: '.$user['username'].'</p>';
            $html_body .= '<p>New Password: '.$password.'</p>';
            $html_body .= '<p>URL: <a href="'._env('ABS_PATH').'/admin">Login URL</a></p>';
            $html_body .= '</body></html>';

            $dbInput = [
                'password'      => $encPass,
                'salt'          => $salt
            ];

            if( $userModel->update( $userid, $dbInput) ) {

                // Send Verification Email
                // TODO: Make it a cronjob in production
                $this->_send_email( $user['email'], $user['display_name'], 'Password Reset by ' . _env('APP_NAME'), $html_body );

                $this->formResponse = [
                    'status'        => true,
                    'textMessage'   => 'User password reset successful'
                ];

            }
            else {

                $this->formResponse['errors'][] = 'Unable to update user';

            }

        }


        // Send Response
        $this->send_json_response();

    }


    /**
     * Send a email
     * @param string $email
     * @param string $name
     * @param string $subject
     * @param string $htmlbody
     */
    private function _send_email( $email, $name, $subject, $htmlbody )
    {
        // Send Validation Email with Password
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = _env('EMAIL_SMTP_SERVER');
            $mail->SMTPAuth   = true;
            $mail->Username   = _env('EMAIL_SMTP_USER');
            $mail->Password   = _env('EMAIL_SMTP_PASS');
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = _env('EMAIL_SMTP_SSL_PORT');

            //Recipients
            $mail->setFrom(_env('EMAIL_SMTP_USER'), 'Demo User');
            $mail->addAddress($email, $name);

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $htmlbody;

            $mail->send();
            
            log_message("Message has been sent");

        } catch (Exception $e) {
            log_message("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }


}