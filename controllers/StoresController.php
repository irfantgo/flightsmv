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

        $storeModel = new Stores();

        // Check whether logged in user is a super manager
        if( Session::get('user')['super_manager'] == true )  {
            $stores = $storeModel->allStores();
        }

        // Else, show only stores who's access
        else {
            $stores = $storeModel->get_stores_of_manager( Session::get('user')['user_id'] );
        }
        
        $this->view('cpanel.stores.show', ['stores' => $stores]);
    }

    /**
     * Add Managers
     * @param int $storeid
     * @return void
     */
    public function addmanager( $storeid )
    {

        // Store Information
        $storeModel = new Stores();
        $store = $storeModel->_get([
            'andWhere' => [
                ['ID', $storeid, '=']
            ]
        ])[0];
        $store_managers = $storeModel->a_store_managers( $storeid );
        $store_managers_arr = [];
        if( !empty($store_managers) ) {
            foreach( $store_managers as $sm ) {
                $store_managers_arr[] = $sm['user_id'];
            }
        }

        // Fetch all the store managers
        $userModel = new Users();
        $managers = $userModel->all_active_users();

        $this->view('cpanel.stores.addmanager', ['store' => $store, 'store_managers' => $store_managers, 'sm_array' => $store_managers_arr, 'managers' => $managers]);
    }

    /**
     * Show all store items
     * @param int $storeid
     * @return void
     */
    public function items( $storeid )
    {

        $storeModel = new Stores();
        $store = $storeModel->_get([
            'andWhere' => [
                ['ID', $storeid, '=']
            ]
        ])[0];

        $stockModel = new Stock();
        $stock = $stockModel->get_items( $storeid );

        // Collect all item types
        $itemtypes = [];
        if( !empty($stock) ) {
            foreach( $stock as $ss ) {
                if( in_array($ss['item_type'], $itemtypes) == false ) {
                    $itemtypes[] = $ss['item_type'];
                }
            }
        }

        // Added extra flag to identify active PR item
        $revisedStock = [];
        $stockCount = 0;
        foreach( $stock as $ss ) {

            $prModel = new PurchaseOrder();

            $revisedStock[$stockCount] = $ss;
            $revisedStock[$stockCount]['pr_raised'] = $prModel->check_if_item_in_pr($storeid, $ss['item_code']);

            $stockCount++;
        }

        // Render Viwe
        $this->view('cpanel.stores.items', ['items' => $revisedStock, 'store' => $store, 'item_types' => $itemtypes]);

    }

    /**
     * Get all the purchase requests
     * @param int $storeid
     */
    public function purchaserequests( $storeid )
    {

        $storeModel = new Stores();
        $store = $storeModel->_get([
            'andWhere' => [
                ['ID', $storeid, '=']
            ]
        ])[0];

        $prModel = new PurchaseOrder();
        $purchaseRequests = $prModel->get_purchase_orders( $storeid );

        $this->view( 'cpanel.stores.purchaserequests', ['store' => $store, 'prs' => $purchaseRequests] );

    }

    /**
     * Get purchase requisition items
     * @param int $prids
     */
    public function pritems( $prid )
    {
        
        // Fetch all the items for PR ID
        $prModel = new PurchaseOrder();
        $records = $prModel->get_pr_items( $prid );
        $this->view( 'cpanel.stores.pr-item-list', ['items' => $records] );

    }

    /**
     * Generate PDF
     * @param int $store_id
     */
    public function generate( $store_id )
    {
        // Authenticate User
        // $this->ajaxAuthentication( 'MNG_USER' );

        // Create a new purchase order
        $purchaseRequestModel = new PurchaseOrder();
        $purchaseRequestModel->create( $store_id, Session::get('user')['user_id'] );
        
        // Get the Purchase Order ID
        $prid = $purchaseRequestModel->last_record_id;

        $itemsList = '';

        // Check whether there are items to process
        if( empty($this->formData['cc_items'])  ) {
            $this->formResponse['errors'][] = 'No data to process';
        }

        // If there are items to process
        if( !empty($this->formData['cc_items']) ) {

            // Fetch data and process
            $stockModel = new Stock();

            // Loop all the items
            foreach( $this->formData['cc_items'] as $id ) {

                $item = $stockModel->get_store_item( $id )[0];

                // Start of new item
                $itemsList .= '<tr>';

                // Item Code
                $itemsList .= '<td>'.$item['item_code'].'</td>';

                // Description
                $itemsList .= '<td>'.$item['item_desc'].'</td>';

                // Quantity on hand
                $itemsList .= '<td>'.$item['qoh'].'</td>';

                // Quantity on physical count
                $itemsList .= '<td></td>';

                // Usage / Monthly
                $itemsList .= '<td></td>';

                // Unit of Measures
                $itemsList .= '<td>'.$item['store_uom'].'</td>';

                // Order Quantity
                $itemsList .= '<td></td>';

                // Unit Price (MVR)
                $itemsList .= '<td></td>';

                // Total Amount (MVR)
                $itemsList .= '<td></td>';

                // End of new item
                $itemsList .= '</tr>';

                // Add new item to purchase order items
                $purchaseRequestModel->addItem($prid, $item['item_code'], $item['item_desc'], $store_id);

            }

            // Fetch the template
            $email_template = file_get_contents(dirname(__DIR__) . '/resources/html_templates/email_procure_reorder.html');

            // Appended items to template
            $content = str_replace('[::ORDER_LIST::]', $itemsList, $email_template);

            // Generate PDF
            $dompdf = new Dompdf();
            $dompdf->loadHtml($content);
            
            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'portrait');
            
            // Render the HTML as PDF
            $dompdf->render();
            
            $storage_folder = _env('PATH_TRASH');
            $file_name = $storage_folder . '/tmp_file.pdf';
            
            // Check for trash directory, create if not found
            if( is_dir($storage_folder) == false ) { mkdir($storage_folder, 0775, true); }

            // Save PDF
            file_put_contents($file_name, $dompdf->output()); 

            $this->formResponse['status'] = true;
            $this->formResponse['textMessage'] = 'PDF generated successfully';
            
        }
        
        $this->send_json_response();

    }

    /**
     * Download PDF File
     */
    public function downloadpdf()
    {
        // Download File
        $storage_folder = _env('PATH_TRASH');
        $file_name = $storage_folder . '/tmp_file.pdf';
        $downloadfilename = 'procurement_reorder_' . date('Y-m-d_Hi') . '.pdf';

        header('Content-Description: File Transfer');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$downloadfilename.'"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file_name));
        header('Accept-Ranges: bytes');
        readfile($file_name);
    }


    /**
     * Add Manager Process
     */
    public function addmanagerprocess()
    {

        // Authenticate User
        $this->ajaxAuthentication( 'MNG_USER' );

        $rData = [
            'status' => false,
            'message' => 'Unable to add manager'
        ];

        $storeid = $_POST['store_id'];
        $userid = $_POST['user_id'];
        $perform = $_POST['perform'];

        $storeModel = new Stores();

        // Perform access
        if( $perform == 'access' ) {

            $dbinput = [
                'store_id' => $storeid,
                'manager_id' => $userid,
                'send_alert' => 0
            ];
    
            if( $storeModel->conn->insert('store_managers', $dbinput) ) {
    
                $logs = new Logs();
                $logs->add( Session::get('user')['display_name'] . ' added ' . $userid . ' to ' . $storeid);
    
                $rData = [
                    'status' => true,
                    'message' => 'Manager added successfully'
                ];
            }

        }

        // Perform alert
        if( $perform == 'alert' ) {

            $dbinput = [
                'send_alert' => 1
            ];
    
            $storeModel->conn->where('store_id', $storeid);
            $storeModel->conn->where('manager_id', $userid);

            if( $storeModel->conn->update('store_managers', $dbinput) ) {
    
                $logs = new Logs();
                $logs->add( Session::get('user')['display_name'] . ' alert set for ' . $userid . ' to ' . $storeid);
    
                $rData = [
                    'status' => true,
                    'message' => 'Alert set successfully'
                ];
            }

        }


        echo json_encode($rData);

    }

    /**
     * Add Manager Process
     */
    public function rmmanagerprocess()
    {

        // Authenticate User
        $this->ajaxAuthentication( 'MNG_USER' );

        $rData = [
            'status' => false,
            'message' => 'Unable to remove manager'
        ];

        $storeid = $_POST['store_id'];
        $userid = $_POST['user_id'];
        $perform = $_POST['perform'];

        $storeModel = new Stores();


        // Perform access
        if( $perform == 'access' ) {

            $storeModel->conn->where('store_id', $storeid);
            $storeModel->conn->where('manager_id', $userid);
    
            if( $storeModel->conn->delete('store_managers') ) {
    
                $logs = new Logs();
                $logs->add( Session::get('user')['display_name'] . ' removed ' . $userid . ' from ' . $storeid);
    
                $rData = [
                    'status' => true,
                    'message' => 'Manager removed successfully'
                ];
            }

        }

        // Perform alerts
        if( $perform == 'alert' ) {

            $dbinput = [
                'send_alert' => 0
            ];
    
            $storeModel->conn->where('store_id', $storeid);
            $storeModel->conn->where('manager_id', $userid);

            if( $storeModel->conn->update('store_managers', $dbinput) ) {
    
                $logs = new Logs();
                $logs->add( Session::get('user')['display_name'] . ' alert unset for ' . $userid . ' to ' . $storeid);
    
                $rData = [
                    'status' => true,
                    'message' => 'Alert removed successfully'
                ];
            }

        }



        echo json_encode($rData);

    }


    public function store()
    {

    }

    public function update( $id = null )
    {

    }

    public function destroy()
    {

    }

}