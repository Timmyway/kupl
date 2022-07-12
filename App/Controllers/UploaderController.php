<?php
namespace App\Controllers;
use App\Api\Uploader;
use App\AppConfig;

class UploaderController
{    
    public static function upload()
    {
        $uploader = new Uploader(AppConfig::getInstance()->get('root').'kits');
        $uploader->uploadKit();
        $uploader->prepareKit();
    }
}
?>