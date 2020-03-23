<?php
/**
 * Dashboard Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Session;
class DashboardController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index()
    {  

        // Fetch Users
        $usersModel = new Users();
        $users = count($usersModel->_get());

        $this->view('cpanel.dashboard.show', [
            'users' => $users
        ]);
        
    }

    public function create()
    {
        $this->view('home');
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