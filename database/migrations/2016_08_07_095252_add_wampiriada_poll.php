<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWampiriadaPoll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wampiriada_polls', function (Blueprint $table) {
            $table->integer('poll_id')->unsigned();
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');

            $table->integer('edition_id')->unsigned();
            $table->foreign('edition_id')->references('id')->on('editions');

            $table->primary(['poll_id', 'edition_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wampiriada_polls');
    }
}
