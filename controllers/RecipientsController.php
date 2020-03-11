<?php
/**
 * Recipients Controller
 * @author Ahmed Shan (@thaanu16)
 *
 */
use \Dompdf\Dompdf;
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
class RecipientsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index()
    {

        $recipientsModel = new Recipients();
        $recipients = $recipientsModel->_get();

        // Render View
        $this->view('cpanel.recipients.show', ['recipients' => $recipients]);

    }

    /**
     * Create new recipients
     * @return void
     */
    public function create()
    {

        // Render view
        $this->view('cpanel.recipients.create');

    }

    /**
     * Store recipients information
     * @return json
     */
    public function store()
    {

        $formRequirments = [
            'full_name' => [
                'required' => true,
                'label' => 'Full Name'
            ],
            'email' => [
                'required' => true,
                'unique' => 'recipients',
                'label' => 'Email'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirments);

        if( $validation->passed() ) {

            $dbInput = [
                'full_name' => $this->formData['full_name'],
                'email' => $this->formData['email'],
                'status' => 'active'
            ];

            $recipientsModel = new Recipients();

            if( $recipientsModel->insert($dbInput) ) {

                $this->formResponse = [
                    'status' => true,
                    'textMessage' => 'Recipient created successfully'
                ];

            }
            else {
                $this->formResponse['errors'][] = 'Unable to create recipient';
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


        // Fetch the select recipient
        $recipientsModel = new Recipients();
        $recipient = $recipientsModel->find($id);

        if( empty($recipient) ) {
            error_header('404');
        }

        // Render View
        $this->view('cpanel.recipients.edit', ['recipient' => $recipient]);

    }

    /**
     * Update given recipient
     * @param  int $id
     * @return json
     */
    public function patch( $id )
    {

        $formRequirments = [
            'full_name' => [
                'required' => true,
                'label' => 'Full Name'
            ],
            'email' => [
                'required' => true,
                'uniquebut' => [
                    'tablename' => 'recipients',
                    'primary_key' => 'ID',
                    'primary_key_value' => $id
                ],
                'label' => 'Email'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirments);

        if( $validation->passed() ) {

            $dbInput = [
                'full_name' => $this->formData['full_name'],
                'email' => $this->formData['email'],
                'status' => ( isset($this->formData['status']) ? 'active' : 'inactive' )
            ];

            $recipientsModel = new Recipients();

            if( $recipientsModel->update($id, $dbInput) ) {

                $this->formResponse = [
                    'status' => true,
                    'textMessage' => 'Recipient updated successfully'
                ];

            }
            else {
                $this->formResponse['errors'][] = 'Unable to update recipient';
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
