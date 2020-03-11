<?php
/**
 * Items Controller
 * @author Ahmed Shan (@thaanu16)
 *
 */
use \Dompdf\Dompdf;
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
class ItemsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null )
    {

        // Fetch all the items
        $itemsModel = new Items();
        $items = $itemsModel->_get([
            'orderBy' => [
                ['created_dt', 'DESC']
            ]
        ]);

        $this->view('cpanel.items.show', ['items' => $items]);

    }

}
