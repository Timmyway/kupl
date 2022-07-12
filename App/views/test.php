<?php 
    header("Content-Type: application/json; charset=UTF-8");
    // use App\Models\Kit;
    use Illuminate\Database\Capsule\Manager as Capsule;

    // Capsule::schema()->create('kits', function($table) {
    //     $table->increments('id');
    //     $table->string('name');
    //     $table->string('location');
    //     $table->text('code');
    
    //     $table->timestamps();
    // });    

    echo json_encode(['kits' => $kits]);
?>