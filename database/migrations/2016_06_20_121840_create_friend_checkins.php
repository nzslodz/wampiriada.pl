<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NZS\Wampiriada\Checkins\Friend\FriendCheckin;
use NZS\Wampiriada\FacebookConnection;
use NZS\Wampiriada\Checkins\Friend\FriendCheckinActivityClass;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Core\Activity;

class CreateFriendCheckins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $facebook_connections = FacebookConnection::get();

        foreach($facebook_connections as $connection) {
            $checkins = Checkin::whereUserId($connection->source_id)->get();
            foreach($checkins as $checkin) {
                $friend = Checkin::whereEditionId($checkin->edition_id)->whereUserId($connection->target_id)->first();
                if(!$friend) {
                    continue;
                }

                $reverse_connection = FacebookConnection::whereTargetId($connection->source_id)->whereSourceId($connection->target_id)->first();

                FriendCheckin::firstOrCreate([
                    'facebook_connection_id' => $connection->id,
                    'checkin_id' => $checkin->id,
                    'friend_checkin_id' => $friend->id,
                ]);

                FriendCheckin::firstOrCreate([
                    'facebook_connection_id' => $reverse_connection->id,
                    'checkin_id' => $friend->id,
                    'friend_checkin_id' => $checkin->id,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        FriendCheckin::truncate();
        Activity::whereClassName(FriendCheckinActivityClass::class)->delete();
    }
}
