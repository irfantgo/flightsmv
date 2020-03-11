<?php
/**
 * Images Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use WideImage\WideImage;
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Files;

class ImagesController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    // Default method
    public function index()
    {}

    /**
     * Get the client logo
     * @param int $client_id
     * @param string $size
     * @return void
     */
    public function client_logo( $client_id, $size )
    {

        // Fetch client information
        $client = new Clients();
        $client_record = $client->find($client_id);

        // Extract the size
        $s = explode('x', $size);
        $w = $s[0];
        $h = $s[1];

        if( empty($client_record) ) {
            
            // Show default image
            $this->_load_image( _env('PATH_HF_ASSETS') . '/dummy.jpg', $w, $h );
            exit;
            
        }
        
        $file = _env('PATH_CLIENTS_DOC') . '/' . $client_record['company_logo'];
        $this->_load_image( $file, $w, $h );
        exit;

    }

    /**
     * Load image
     */
    private function _load_image( $filename, $w, $h )
    {

        $extension = pathinfo( $filename )['extension'];

        $image = WideImage::load($filename);
        $resized = $image->resize($w, $h, 'outside', 'down');
        $resized->output($extension);

    }

}