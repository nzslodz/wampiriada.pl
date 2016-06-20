<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFriendCheckin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facebook_connections', function(Blueprint $table) {
            $table->dropPrimary(['source_id', 'target_id']);
        });

        Schema::table('facebook_connections', function(Blueprint $table) {
            $table->increments('id');

            $table->index(['source_id', 'target_id']);
        });

        Schema::create('friend_checkins', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activities');

            $table->integer('checkin_id')->unsigned();
            $table->foreign('checkin_id')->references('id')->on('checkins');
            $table->integer('friend_checkin_id')->unsigned();
            $table->foreign('friend_checkin_id')->references('id')->on('checkins');

            $table->integer('facebook_connection_id')->unsigned();
            $table->foreign('facebook_connection_id')->references('id')->on('facebook_connections');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('friend_checkins');

        Schema::table('facebook_connections', function(Blueprint $table) {
            $table->dropIndex(['source_id', 'target_id']);
        });
        Schema::table('facebook_connections', function(Blueprint $table) {
            $table->dropColumn('id');

            $table->primary(['source_id', 'target_id']);
        });
    }
}
