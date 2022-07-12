<?php
namespace App\Models;
use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('kits', function($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('location');
    $table->text('code');

    $table->timestamps();
});