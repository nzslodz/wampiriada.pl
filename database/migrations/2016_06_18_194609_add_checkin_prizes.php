<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckinPrizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_prizes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->timestamp('claimed_at')->nullable();
            $table->longText('description');
            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->integer('checkin_id')->unsigned()->nullable();
            $table->foreign('checkin_id')->references('id')->on('checkins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('checkin_prizes');
    }
}
