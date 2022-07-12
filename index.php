<?php 
require __DIR__ . '/vendor/autoload.php';

use App\Router;
use Illuminate\Database\Capsule\Manager as Capsule;

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
$capsule->bootEloquent();

$router = new Router;
$router::init();
?>