<?php
/**
 * Router Class
 * @author Ahmed Shan (@thaanu16)
 */
namespace Heliumframework;

use \Heliumframework\Requests;
use Exception;

class Router
{

    static protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    public static function load( $file )
    {
        $router = new static;
        require $file;
        return $router;
    }

    /**
     * Server a GET request
     */
    public static function get( $uri, $controller )
    {
        $split = explode('@', $controller);
        self::$routes['GET'][$uri] = ['controller' => $split[0], 'method' => $split[1]];
    }

    /**
     * Server a POST request
     */
    public static function post( $uri, $controller )
    {
        $split = explode('@', $controller);
        self::$routes['POST'][$uri] = ['controller' => $split[0], 'method' => $split[1]];
    }

    /**
     * Redirect traffic to requested controller
     * @param string $uri
     * @param string $requestType
     */
    public function direct( $uri, $requestType )
    {

        if( array_key_exists(trim($uri), self::$routes[$requestType]) ) {

            $__x = self::$routes[$requestType][$uri];

            $controller_file = dirname(__DIR__) . '/controllers/' . $__x['controller'] . '.php';

            // Check if controller exists
            if( file_exists( $controller_file ) ) {

                require $controller_file;

                // Create new instance of the controller
                $controller = new $__x['controller']();

                // Check if method exists
                if( method_exists($controller, $__x['method']) ) {

                    // Call method and parse parameters
                    call_user_func_array( [$controller, $__x['method']], Requests::params() );

                }
                // Else, throw exception
                else {
                    // throw new Exception('Method not found');
                    log_message("Method not found");
                    error_header(404);
                }

            }
            else {
                log_message("Controller not found");
                error_header(404);
            }

        }
        else {

            log_message("No route set");
            error_header(404);

        }

    }

}

