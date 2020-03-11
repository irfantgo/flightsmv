<?php
/**
 * Notifications Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
class NotificationsController extends Controller
{

    public function index( $id = null )
    {

        $notify = [
            'messages' => [
                ['message' => 'abc'],
                ['message' => 'hij'],
                ['message' => 'xyz']
            ],
            'count' => 3
        ];

        echo json_encode($notify);

    }

}