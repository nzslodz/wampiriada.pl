<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Profile;
use App\User;

class CleanSpacesFromCheckins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach(Checkin::all() as $checkin) {
            $checkin->name = trim(preg_replace('/\s+/u', ' ', $checkin->name));
            $checkin->save();
        }

        foreach(Profile::all() as $profile) {
            $profile->current_name = trim(preg_replace('/\s+/u', ' ', $profile->current_name));
            $profile->save();

            if($profile->user->first_name || $profile->user->last_name) {
                continue;
            }

            list($profile->user->first_name, $profile->user->last_name) = $profile->getNameAsPair();

            $profile->user->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
