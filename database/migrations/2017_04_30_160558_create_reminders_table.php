<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wampiriada_reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->integer('action_day_id')->unsigned();
            $table->foreign('action_day_id')->references('id')->on('action_days');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wampiriada_reminders');
    }
}
