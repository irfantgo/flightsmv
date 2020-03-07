<?php 

        ini_set('display_errors', 1);

        $str = '/nid A106667';

        preg_match("/\/[a-zA-Z]*/", $str, $matches);

        print_r($matches);