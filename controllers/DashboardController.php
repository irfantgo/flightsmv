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

        // Fetch Recipients
        $recipientsModel = new Recipients();
        $recipients = count($recipientsModel->_get());

        // Fetch Users
        $usersModel = new Users();
        $users = count($usersModel->_get());

        // Fetch Departments
        $departmentsModel = new Departments();
        $departments = count($departmentsModel->_get());

        $this->view('cpanel.dashboard.show', [
            'recipients' => $recipients, 
            'users' => $users,
            'departments' => $departments
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