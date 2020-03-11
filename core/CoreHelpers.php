<?php
    /**
     * Some functions to help the core
     * @author Ahmed Shan (@thaanu16)
     */

    use Heliumframework\Session;

    /**
     * A function to get the environment file
     * @param string $var
     * @return void
     */
    function _env( $var )
    {
        $config = [];
        $env_file = dirname(__DIR__) . '/.env';
        if( file_exists( $env_file) ) {
            $envContent = file_get_contents($env_file);
            if( !empty($envContent) ) {
                $lines = explode("\n", $envContent);
                foreach( $lines as $line ) {
                    if( !empty($line) ) {
                        $exploded = explode('=', $line);
                        $config[trim($exploded[0])] = trim($exploded[1]);
                    }
                }
                if( array_key_exists($var, $config) ) {
                    return $config[$var];
                }
            }
        }
        error_log("Unable to find Environment File");
        return false;
    }

    /**
     * A function to get the environment file and output the variable
     * @param string $var
     * @return void
     */
    function env( $var ) 
    {
        echo _env($var);
    }

    /**
     * Dump & Die - Show a message and die
     * @param void $message
     * @return string
     */
    function dd( $message = '' )
    {
        $msg = '';

        if( !empty($message) ) {

            $msg .= '<div style="padding: 40px; border: 5px solid red; background: #eee; font-family: helvetica;">';
            $msg .= '<h2 style="padding:0; margin:0 0 20px 0; text-transform: uppercase;">Die &amp; Dump</h2>';

            // Handle Array
            if( is_array($message) ) {
                $msg .= '<pre>';
                $msg .= print_r($message, true);
                $msg .= '</pre>';
            }
            else {
                $msg .= $message;
            }


            $msg .= '</div>';

        }

        die($msg);

    }

    /**
     * Display a message, only used for debugging (Works on in DEV MODE)
     * @param string $message
     */
    function debugMsg( $message ) 
    {
        // Check whether the app is in dev mode
        if( _env('DEV_MODE') ) {
            echo '<div style="padding: 10px; border: 5px solid #333; margin: 20px 0; font-family: helvetica;">';
            echo '<h6 style="color: purple; margin: 0; padding: 0;">DEBUG MESSAGE</h6>';
            echo '<pre>'; print_r($message); echo '</pre>';
            echo '</div>';
        }
    }

    /**
     * Error headers
     * @param int $errorcode
     * @return void
     */
    function error_header( $errorcode )
    {
        switch( $errorcode ) {
            case 404:
                include(dirname(__DIR__) . '/errors/404.html'); exit; break;
            case 500:
                include(dirname(__DIR__) . '/errors/500.html'); exit; break;
            case 401:
                include(dirname(__DIR__) . '/errors/401.html'); exit; break;
            case 419:
                include(dirname(__DIR__) . '/errors/419.html'); exit; break;

        }
    }

    /**
     * Load CSS and JS files
     * @param string path
     * @return string
     */
    function assets( $path )
    {
        echo _env('ABS_PATH') . $path;
    }

    /**
     * Redirect user
     * @param string $path
     * @return void
     */
    function redirectTo( $path )
    {
        Header('location: ' . $path);
        exit;
    }

    /**
     * Find the active tab
     * @param string $route
     * @param int $placement
     * @return boolean
     */
    function isActiveTab( $route, $placement = null )
    {

        $urlParser = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
        $urlParserCount = count($urlParser) - 1;

        $routeParser = explode('/', ltrim($route, '/'));
        $routeParserCount = count($routeParser) - 1;

        // Check if placement is let
        if( is_numeric($placement) ) {

            // Check whether the tabs match
            if( $urlParser[$placement] == $routeParser[$placement] ) {
                return true;
            }

        }
        // Else, if no placement is set
        else {
            
            // Check whether array count matches
            if($urlParserCount == $routeParserCount) {
    
                // Check whether the tabs match
                if( $urlParser[$urlParserCount] == $routeParser[$routeParserCount] ) {
                    return true;
                }
    
            }

        }

        return false;
        
    }

    /**
     * Log a given message
     * @param string $message
     */
    function log_message( $message )
    {
        $logFile = dirname(__DIR__) . '/trash/logFile.txt';

        // Create a file if does not exist
        if( file_exists($logFile) == false ) {
            touch($logFile);
        }

        // Read File
        $oldContent = file_get_contents($logFile);

        // Append
        $newContent = date('Y-m-d H:i:s') . "\t";
        $newContent .= $message . "\n";
        $newContent .= $oldContent;

        // Write File
        file_put_contents($logFile, $newContent);

    }

    /**
     * Thaana Date
     * @param string $date
     * @param boolean $show_day
     * @return string
     */
    function thaana_date($date, $show_day = false)
    {

        $newDate = $date;

        $months = [
            'ޖެނުއަރީ',
            'ފެބްރުއަރީ',
            'މާޗް',
            'އޭޕްރިލް',
            'މެއި',
            'ޖޫން',
            'ޖުލައި',
            'އޮގަސްޓް',
            'ސެޕްޓެމްބަރ',
            'އޮކްޓޯބަރ',
            'ނޮވެމްބަރ',
            'ޑިސެމްބަރ'
        ];

        $days = [
            'ހޯމަ',
            'އަންގާރަ',
            'ބުދަ',
            'ބުރާސްފަތި',
            'ހުކުރު',
            'ހޮނިހިރު',
            'އާދިއްތަ'
        ];

        $year = date('Y', strtotime($date));
        $month = date('n', strtotime($date)) - 1;
        $day = date('j', strtotime($date));
        $day_no = date('N', strtotime($date)) - 1;

        $day_thaana = $days[$day_no];

        $newDate = $day . ' <span class="thaana-text">' . $months[$month]  . '</span> ' . $year;

        if( $show_day ) {
            $newDate .= ' ,'. $day_thaana;
        }

        return $newDate;

    }
    

