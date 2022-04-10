<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLikesTable extends Migration
{
     public function up()
     {
         Schema::table('likes', function (Blueprint $table) {
             $table->dropColumn('created_at');
         });
     }

    public function down()
    {
        //
    }
}
