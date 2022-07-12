<?php
namespace App;
use Illuminate\Database\Capsule\Manager as Capsule;

class AppConfig
{
    private $_config;
    private static $_instance = null;

    private function __construct()
    {
        $this->init();        
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {            
            self::$_instance = new AppConfig();
        }                        
        return self::$_instance;
    }

    public function get($key)
    {
        return isset($this->_config[$key]) ? $this->_config[$key] : '';
    }

    private function init()
    {
        $this->_config = array(
            'host' => 'localhost',
            'username' => 'root',
            'pass' => '',
            'database' => 'kupl',
            'app_url' => 'http://localhost:8020/',
            'root' => $_SERVER["DOCUMENT_ROOT"].'/',
            'site_url' => ($_SERVER['SERVER_NAME'] == 'localhost'
                ? 'http://localhost:8020/'
                : 'https://timtest.kontikimedia.com/kupl/'
            ),
            'controllers' => $_SERVER["DOCUMENT_ROOT"].'/App/Controllers/',
            'views' => $_SERVER["DOCUMENT_ROOT"].'/App/views/',
            'assets' => $_SERVER["DOCUMENT_ROOT"].'/assets/',
        );

        $capsule = new Capsule;
 
        $capsule->addConnection([
            'driver'   => 'mysql',
            'host'     => 'localhost',
            'database' => 'kupl',
            'username' => 'root',
            'password' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'   => '',
        ]);

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();
    }
}