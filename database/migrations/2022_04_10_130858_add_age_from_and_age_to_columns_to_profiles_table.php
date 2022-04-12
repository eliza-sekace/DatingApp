<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgeFromAndAgeToColumnsToProfilesTable extends Migration
{

    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
         $table->unsignedInteger('age_from')
             ->nullable()
             ->after('location');

         $table->unsignedInteger('age_to')
             ->nullable()
             ->after('age_from');
        });
    }

    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('age_from');
            $table->dropColumn('age_to');
        });
    }
}
