<?php namespace App;
use App\AppConfig;
use App\Controllers\UploaderController;

class Router
{
    public static function init()
    {
        $config = AppConfig::getInstance();
        $request = $_SERVER['REQUEST_URI'];

        switch ($request) { 
            case '':
            case '/':
                include $config->get('views').'home.php';
                break; 
            case '/test':
                include $config->get('views').'test.php';
            case '/upload':
                UploaderController::upload();
                break;
            default:
                http_response_code(404);
                include $config->get('views').'404.php';
                break;
        }        
    }
}