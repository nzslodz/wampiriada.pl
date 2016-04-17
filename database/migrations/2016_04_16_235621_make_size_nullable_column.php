<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeSizeNullableColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkins', function(Blueprint $table) {
            $table->integer('size_id')->unsigned()->nullable()->change();
        });

        Schema::table('wampiriada_profile', function(Blueprint $table) {
            $table->integer('default_size_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
