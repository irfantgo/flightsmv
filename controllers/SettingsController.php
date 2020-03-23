<?php
/**
 * Settings Controller
 * @author Ahmed Shan (@thaanu16)
 *
 */
use \Dompdf\Dompdf;
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
class SettingsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index()
    {

        // Authenticate
        $this->viewAuthenticate('UP_SETTINGS');

        $settingsModel = new Settings();
        $settingsRecords = $settingsModel->all();

        $settings = [];

        // run_date_time

        if( !empty($settingsRecords) ) {
            for( $i=0; $i<count($settingsRecords); $i++ ) {

                $label = ucwords(str_replace('_', ' ', $settingsRecords[$i]['field']));

                switch( $settingsRecords[$i]['field'] ) {
                    case 'run_date_time' :
                        $label .= ' <small>(Format: DD HH:mm)</small> ';
                        break;
                    default:
                        
                    break;
                }

                $settings[$i]['field'] = $settingsRecords[$i]['field'];
                $settings[$i]['label'] = $label;
                $settings[$i]['value'] = $settingsRecords[$i]['value'];
            }
        }

        // Render View
        $this->view('cpanel.settings.show', ['settings' => $settings]);

    }

    public function update()
    {

        // Authenticate
        $this->ajaxAuthentication('UP_SETTINGS');

        $settingsModel = new Settings();
        $total_settings = count($this->formData['settings']);
        $updated_settings = 0;
        
        foreach( $this->formData['settings'] as $k => $v ) {
            
            $settingsModel->conn->where('field', $k);
            if($settingsModel->conn->update('settings', ['value' => $v])) {
                $updated_settings++;
            }

        }

        if( $total_settings == $updated_settings ) {
            $this->formResponse['status'] = true;
            $this->formResponse['textMessage'] = 'Settings updated successfully';
        } else {
            $this->formResponse['errors'][] = 'Unable to update all settings';
        }

        // Send Response
        $this->send_json_response();

    }


}
