<?php
/**
 * AUTHENTICATION
 * @author Ahmed Shan (@thaanu16)
 */
use Heliumframework\Session;
namespace Heliumframework;
class Auth 
{

    /**
     * Check whether user's session is set
     * @return boolean
     */
    public static function userLogged()
    {
        if( self::isLoggedIn() == false ) {
            // Redirect to login page
            redirectTo( _env('LOGIN_URL') );
        }
    }

    /**
     * A function to check whether user is already logged in
     * @return boolean
     */
    public static function isLoggedIn()
    {
        return ( Session::exists('user') ? true : false );
    }

    /**
     * Set user session
     * @param array $userinfo
     * @return boolean
     */
    public static function setUserSession( $userinfo )
    {
        Session::put('user', $userinfo);
    }

    /**
     * Check whether user has requested permission
     * @param string $permission (Optionally can be an array)
     * @return boolean
     */
    public static function hasPermission( $permission )
    {
        
        $ok = false;
        
        // Check for an array
        if( is_array($permission) ) {

            // Loop all the permissions
            foreach( $permission as $p ) {
                // Check whether user has permission
                if( isset(Session::get('user')['roles']) && in_array($p, Session::get('user')['roles']) ) {
                    $ok = true;
                    break;
                }
            }

        }
        // Normal process
        else {

            // Check whether user has permission
            if( isset(Session::get('user')['roles']) && in_array($permission, Session::get('user')['roles']) ) {
                $ok = true;
            }

        }

        return $ok;
    }

}