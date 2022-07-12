<?php
namespace App\Controllers;
use App\Api\Uploader;
use App\AppConfig;

class UploaderController
{    
    public static function upload()
    {
        $save_folder = isset($_POST['save_folder']) ? '/'.$_POST['save_folder'] : '';
        $uploader = new Uploader(AppConfig::getInstance()->get('root').'kits', 
            $save_folder
        );
        $uploader->uploadKit();
        $kit = $uploader->prepareKit();
        var_dump($kit);
        KitController::store($kit);
        Uploader::backHome();
        
    }    
}
?>