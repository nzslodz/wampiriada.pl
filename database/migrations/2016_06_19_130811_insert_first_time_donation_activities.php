<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Checkins\FirstTimeDonatingActivityClass;
use NZS\Core\Activity;

// XXX will fail
class InsertFirstTimeDonationActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach(Checkin::whereFirstTime(true)->get() as $checkin) {
            $activity_class = new FirstTimeDonatingActivityClass;
            $activity_class->saveActivityInstance($checkin);
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
