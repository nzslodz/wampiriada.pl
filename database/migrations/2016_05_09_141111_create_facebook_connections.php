<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacebookConnections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_connections', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('source_id')->unsigned();
            $table->foreign('source_id')->references('id')->on('users');

            $table->integer('target_id')->unsigned();
            $table->foreign('target_id')->references('id')->on('users');

            $table->primary(['source_id', 'target_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('facebook_connections');
    }
}
