<?php

function clean($dest_folder)
{
    //Get a list of all of the file names in the folder.
    echo 'Clean process...';
    $files = glob($dest_folder . '/*'); 
    print_r($files);   
    foreach($files as $file) {
        if (is_file($file)) {
            unlink($file);
        } else {                
            clean($file);
        }
    }
    rmdir($dest_folder);
    echo 'Should have been cleaned';
}

clean('kits');