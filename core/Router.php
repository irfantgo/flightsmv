<?php
/**
 * Router Class
 * @author Ahmed Shan (@thaanu16)
 */
namespace Heliumframework;
class Router
{

    static protected $routes = [];
    static protected $parameters = [];

    /**
     * Handle GET methods
     * @param string $route
     * @param string $controllerMethod
     */
    public static function get( $route = '/', $controllerMethod )
    {

        $explode            = explode('@', $controllerMethod);
        self::$routes[ltrim($route,'/')] = ['controller' => $explode[0], 'method' => $explode[1] ];

    }

    /**
     * Load the URL
     */
    public static function loadURL()
    {

        $subfolder      = '';
        $route          = ltrim($_SERVER['REQUEST_URI'], '/');
        $urlParse       = explode('/', $route);

        // Check for admin panel
        if( $urlParse[0] == 'admin' ) {
            $subfolder = 'admin';
        }

        // Check for API
        if( $urlParse[0] == 'api' ) {
            $subfolder = 'api';
        }

        // Check if subfolder is empty
        if( empty($subfolder) ) {
            $controller = $urlParse[0];
            $method = $urlParse[1];
        }
        else {
            $controller = $urlParse[0+1];
            $method = $urlParse[0+2];
            $subfolder = $subfolder . '/';
        }

        $matcher = $subfolder . $controller . '/' . $method;
        $matcher = rtrim($matcher, '/');
        
        // Check if the route exists
        if( array_key_exists($matcher, self::$routes) ) {
            
            $controllerFile = dirname(__DIR__) . '/controllers/' . $subfolder. self::$routes[$matcher]['controller'] . '.php';

            // Check whether controller file exists
            if( file_exists($controllerFile) ) {

                $method = self::$routes[$matcher]['method'];

                // Load the controller
                include( $controllerFile );

                $controllerToLoad = new self::$routes[$matcher]['controller']();

                // Remove anything unwanted
                if( empty($subfolder) ) {
                    unset($urlParse[0]); unset($urlParse[1]);
                }
                else {
                    unset($urlParse[0]); unset($urlParse[1]); unset($urlParse[2]);
                }

                // Set parameters
                if( !empty($urlParse) ) {
                    self::$parameters = array_values($urlParse);
                }

                // Check whether the metho is allowed                    
                if( isset($method) && method_exists( $controllerToLoad, $method) ) {
                        
                    $params = ( !empty(self::$parameters) ? self::$parameters : [] );
                    call_user_func_array( [$controllerToLoad, $method], $params );
                    
                }
                // Else, send a 404 error
                else {

                    // Log the error
                    error_log("Unable to find method");

                    // Show 404 Page Not Found
                    error_header(404);

                }

            }
            // Else, sende a 404 error
            else {

                // Show 404 Page Not Found
                error_header(404);

            }
            
        }
        else {

            // Log the error
            error_log('Controller file not found');

            // Show 404 Page Not Found
            error_header(404);

        }


    }


    public static function test()
    {
        echo '<pre>'; print_r(self::$routes); echo '</pre>';
    }

}

