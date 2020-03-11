<?php

    /**
     * Setting the correct date 
     * @param string $date_string
     * @return string
     */
    function set_date( $date_string )
    {
        $date_string = str_replace('{month}', date('m'), $date_string);
        $date_string = str_replace('{year}', date('Y'), $date_string);
        return $date_string;
    }

    /**
     * Get the alert date
     * @param string $due_date
     * @param int $days
     * @return string
     */
    function get_alert_date( $due_date, $days = 7 )
    {
        $due_date = set_date($due_date);
        return date('Y-m-d', strtotime("-{$days} days", strtotime($due_date)));
    }

    /**
     * A function to write to file
     * @param string $message
     * @param boolean $clear
     * @return boolean
     */
    function wToFile( $message, $clear = false )
    {

        $targetFile = __DIR__ . '/dump';

        // Create file if not exit
        if( file_exists($targetFile) === false ) {
            touch($targetFile);
        }

        $old = file_get_contents($targetFile);

        if( $clear === false ) {
            $new = $old . $message;
        }
        else {
            $new = $message;
        }
        
        if( file_put_contents($targetFile, $new) ) {
            return true;
        }

        return false;

    }