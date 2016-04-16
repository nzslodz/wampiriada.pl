<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActionDayToCheckin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkins', function(Blueprint $table) {
            $table->integer('action_day_id')->unsigned();
            $table->foreign('action_day_id')->references('id')->on('action_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkins', function(Blueprint $table) {
            $table->dropColumn('action_day_id');
        });
    }
}
