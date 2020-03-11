<?php
/**
 * Home Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Controller;
class HomeController extends Controller
{

    public function index( $id = null )
    {

        $this->view('home.show');
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