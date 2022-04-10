<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('photo')->nullable();
        });

    }

    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
