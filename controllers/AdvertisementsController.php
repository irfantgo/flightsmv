<?php
/**
 * Advertisements Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Auth;
use Heliumframework\Files;

class AdvertisementsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null )
    {

        // Initialize
        $advertisements = [];

        // Fetch all existing advertisements
        $advertisementModel = new Advertisements();
        $advertisements = $advertisementModel->_get();

        // Render View
        $this->view('cpanel.advertisements.show', ['advertisements' => $advertisements]);

    }

    /**
     * Store advertisements
     * @param int 
     */
    public function store()
    {

        $formRequirements = [
            'title' => [
                'required' => true,
                'label' => 'Title'
            ]
        ];

        // Form validation
        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirements);

        // Check if form passed validation
        if( $validation->passed() ) {

            $files_uploaded = [];
            $files_expected = 2;
            $sql_failed     = false;

            // Validate Files
            $desktop_file = new Files($_FILES['desktop_file'], _env('PATH_ADVERTISEMENTS'));
            $new_desktop_file = uniqid() . '_desktop.' . $desktop_file->get_extension();
            if( $desktop_file->upload($new_desktop_file) ) {
                $files_uploaded[] = 'desktop_version';
            } else {
                $this->formResponse['errors'][] = 'Unable to upload desktop version';
            }

            $mobile_file = new Files($_FILES['mobile_file'], _env('PATH_ADVERTISEMENTS'));
            $new_mobile_file = uniqid() . '_mobile.' . $mobile_file->get_extension();
            if( $mobile_file->upload($new_mobile_file) ) {
                $files_uploaded[] = 'mobile_version';
            } else {
                $this->formResponse['errors'][] = 'Unable to upload mobile version';
            }

            // Check if all the files uploaded
            if( $files_expected == count($files_uploaded) ) {

                // Create database record
                $advertisementModel = new Advertisements();
                $exe = $advertisementModel->new_ad($this->formData['title'], NULL, $new_desktop_file, $new_mobile_file, $this->formData['location']);

                if( $exe ) {

                    $this->formResponse['status'] = true;
                    $this->formResponse['textMessage'] = 'New Advertisement Created';

                }
                else {

                    $sql_failed = true;
                    $this->formResponse['errors'][] = 'Unable to create new advertisement';
                    $this->formResponse['errors'][] = $advertisementModel->getLastError();

                }

            }

            // Remove already uploaded file, if any of the condition applied
            if( $files_expected != count($files_uploaded) || $sql_failed ) {
                
                if( in_array('desktop_version', $files_uploaded) ) {
                    if( $desktop_file->delete_uploaded_file() == false ) {
                        $this->formResponse['errors'][] = 'Unable to remove desktop version';
                    }
                }

                if( in_array('mobile_version', $files_uploaded) ) {
                    if( $mobile_file->delete_uploaded_file() == false ) {
                        $this->formResponse['errors'][] = 'Unable to remove mobile version';
                    }
                }

            }

        }
        // Bind error fields
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }

        // Send Response
        $this->send_json_response();

    }

    public function destroy()
    {

    }

}