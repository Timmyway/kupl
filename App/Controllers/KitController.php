<?php
namespace App\Controllers;
use Illuminate\Database\Capsule\Manager as Capsule;

header("Content-Type: application/json; charset=UTF-8");

class KitController
{    
    public static function list()
    {
        $kits = Capsule::table('kits')->get();
        echo json_encode(['kits' => $kits]);
    }

    public static function store($postData)
    {        
        Capsule::table('kits')->insert([
            'name' => isset($postData->name) ? $postData->name : '',
            'location' => isset($postData->location) ? $postData->location : '',
            'code' => isset($postData->code) ? $postData->code : '',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['response' => 'Created']);
    }
}
?>