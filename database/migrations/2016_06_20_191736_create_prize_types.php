<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrizeTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prize_types', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('name');
            $table->text('description');
            $table->boolean('active');
        });

        Schema::table('checkin_prizes', function(Blueprint $table) {
            $table->dropColumn('description');
        });

        Schema::create('checkin_prize_items', function(Blueprint $table) {
            $table->integer('prize_type_id')->unsigned();
            $table->foreign('prize_type_id')->references('id')->on('prize_types');

            $table->integer('checkin_prize_id')->unsigned();
            $table->foreign('checkin_prize_id')->references('id')->on('checkin_prizes')->onDelete('cascade');

            $table->primary(['prize_type_id', 'checkin_prize_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('checkin_prize_items');
        Schema::drop('prize_types');
    }
}
