<?php
/**
 * Stores Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use \Dompdf\Dompdf;
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
class StoresController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null )
    {

        // Authenticate
        $this->viewAuthenticate('MNG_SHOPS');

        $storeModel = new Stores();
        $stores = $storeModel->_get();
        
        $this->view('cpanel.stores.show', ['stores' => $stores]);
    }

    /**
     * Create new shops
     */
    public function create()
    {

        // Render VIew
        $this->view('cpanel.stores.create');

    }

    /**
     * Store Information
     */
    public function store()
    {

        // Authentication
        $this->ajaxAuthentication('MNG_SHOPS');

        $formRequirments = [
            'shop_name' => [
                'required' => true,
                'label' => 'Shop Name'
            ],
            'shop_address' => [
                'required' => true,
                'label' => 'Shop Address'
            ],
            'shop_tele' => [
                'required' => true,
                'label' => 'Shop Name'
            ]
        ];

        // Form Validation 
        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirments);

        // Check if form passed validation
        if( $validation->passed() ) {

            $dbInput = [
                'shop_name' => $this->formData['shop_name'],
                'shop_address' => $this->formData['shop_address'],
                'shop_city' => $this->formData['shop_city'],
                'shop_tele' => $this->formData['shop_tele'],
                'shop_email' => $this->formData['shop_email'],
                'shop_fax' => $this->formData['shop_fax'],
                'shop_show' => true
            ];

            $storeModel = new Stores();
            $exe = $storeModel->insert($dbInput);

            if( $exe ) {

                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'Shop created successfully';

            }
            else {
                $this->formResponse['errors'][] = 'Unable to create new shop';
            }

        }
        // Else, bind error fields
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }

        // Send Response
        $this->send_json_response();

    }

    /**
     * Update stop
     */
    public function update( $id = null )
    {

        $storeModel = new Stores();
        $store = $storeModel->_get([
            'andWhere' => [
                ['ID', $id, '=']
            ]
        ]);

        // Render VIew
        $this->view('cpanel.stores.edit', ['store' => $store[0]]);

    }

    /**
     * Update Information
     */
    public function patch( $id )
    {

        // Authentication
        $this->ajaxAuthentication('MNG_SHOPS');

        $formRequirments = [
            'shop_name' => [
                'required' => true,
                'label' => 'Shop Name'
            ],
            'shop_address' => [
                'required' => true,
                'label' => 'Shop Address'
            ],
            'shop_tele' => [
                'required' => true,
                'label' => 'Shop Name'
            ]
        ];

        // Form Validation 
        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirments);

        // Check if form passed validation
        if( $validation->passed() ) {

            $dbInput = [
                'shop_name' => $this->formData['shop_name'],
                'shop_address' => $this->formData['shop_address'],
                'shop_city' => $this->formData['shop_city'],
                'shop_tele' => $this->formData['shop_tele'],
                'shop_email' => $this->formData['shop_email'],
                'shop_fax' => $this->formData['shop_fax'],
                'shop_show' => true
            ];

            $storeModel = new Stores();
            $exe = $storeModel->update($id, $dbInput);

            if( $exe ) {

                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'Shop updated successfully';

            }
            else {
                $this->formResponse['errors'][] = 'Unable to update shop';
            }

        }
        // Else, bind error fields
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