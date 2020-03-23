<?php

    use \Heliumframework\Session;

    /**
     * Set a CSRF session
     * @return string
     */
    function csrf()
    {
        $code = md5(time());
        Session::put('csrf', $code);
        echo '<input type="hidden" name="csrf" value="'.$code.'" />';
    }
    