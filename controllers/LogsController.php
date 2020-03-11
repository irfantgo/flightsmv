<?php
/**
 * Logs Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */

use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
class LogsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null )
    {

        $logsModel = new Logs();
        $logs = $logsModel->get_top_ten_logs();


        $this->view('cpanel.logs.show', ['logs' => $logs]);
    }


}