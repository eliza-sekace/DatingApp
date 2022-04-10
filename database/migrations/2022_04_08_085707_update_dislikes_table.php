<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDislikesTable extends Migration
{

    public function up()
    {
        Schema::table('dislikes', function (Blueprint $table) {
            $table->dropColumn('created_at');
        });
    }


    public function down()
    {
        Schema::dropIfExists('dislikes');
    }
}
