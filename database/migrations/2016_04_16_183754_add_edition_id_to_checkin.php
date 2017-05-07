<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NZS\Wampiriada\Editions\Edition;


class AddEditionIdToCheckin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkins', function(Blueprint $table) {
            $table->integer('edition_id')->unsigned();
            $table->foreign('edition_id')->references('id')->on('editions');
        });

        $edition = new Edition;
        $edition->number = 28;
        $edition->name = '28. edycja';
        $edition->when = '05/2016';
        $edition->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkins', function(Blueprint $table) {
            $table->dropColumn('edition_id');
        });
    }
}
