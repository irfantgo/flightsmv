<?php

    // Fetch all files
    $path = dirname(__DIR__) . '/storage/trash';
    $files = scandir($path);
    
    if( !empty($files) ) {

        // Get all files with prefix 'test_'
        foreach( $files as $file ) {

            $x = explode('_', $file);

            if( $x[0] == 'test' ) {
                unlink($path .'/'. $file);
            }

        }

    }
    