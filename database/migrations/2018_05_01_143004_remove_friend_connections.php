<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFriendConnections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('friend_checkins');
        Schema::drop('facebook_connections');

        DB::table('activities')
            ->whereClassName('NZS\Wampiriada\Checkins\Friend\FriendCheckinActivityClass')
            ->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        throw new Exception("This cannot be migrated back");
    }
}
