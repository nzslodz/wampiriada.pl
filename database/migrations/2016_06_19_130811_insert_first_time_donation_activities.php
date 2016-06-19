<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\FirstTimeDonatingActivityClass;
use NZS\Core\Activity;

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
            FirstTimeDonatingActivityClass::createFromCheckin($checkin);
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